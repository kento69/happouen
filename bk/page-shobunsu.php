<?php
/*
Template Name: QR Code Role-based Validation Quiz
*/

wp_head();

// チームと役職のパターンを定義
$qr_patterns = [
    '001' => ['team01' => ['role01', 'role02'], 'team02' => ['role01', 'role02'], 'team03' => ['role01', 'role02']],
    '002' => ['team01' => ['role02', 'role03'], 'team02' => ['role02', 'role03'], 'team03' => ['role02', 'role03']],
    '003' => ['team01' => ['role01', 'role03'], 'team02' => ['role01', 'role03'], 'team03' => ['role01', 'role03']],
    // その他のパターンも定義...
];

// 役職名の定義（カスタムフィールドから取得）
$role_names = [
    'role01' => get_post_meta(get_the_ID(), 'role01', true) ?: '役職1',
    'role02' => get_post_meta(get_the_ID(), 'role02', true) ?: '役職2',
    'role03' => get_post_meta(get_the_ID(), 'role03', true) ?: '役職3'
];

// チーム名の定義（カスタムフィールドから取得）
$team_names = [
    'team01' => get_post_meta(get_the_ID(), 'team01', true) ?: 'チーム1',
    'team02' => get_post_meta(get_the_ID(), 'team02', true) ?: 'チーム2',
    'team03' => get_post_meta(get_the_ID(), 'team03', true) ?: 'チーム3'
];

// パラメータの取得
$qr_id = isset($_GET['qr']) ? sanitize_text_field($_GET['qr']) : '';
$base_url = home_url('shobunsu');

if (!isset($qr_patterns[$qr_id])) {
    wp_die('Invalid QR code');
}

$required_roles_teams = $qr_patterns[$qr_id];

// 送信されたフォームの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_team = isset($_POST['selected_team']) ? sanitize_text_field($_POST['selected_team']) : '';
    if (empty($selected_team) || !isset($required_roles_teams[$selected_team])) {
        wp_die('Invalid team selection');
    }

    $inputs = [];
    $all_correct = true;

    foreach ($required_roles_teams[$selected_team] as $role) {
        $input_key = 'input_' . $selected_team . '_' . $role;
        $inputs[$role] = isset($_POST[$input_key]) ? sanitize_text_field($_POST[$input_key]) : '';

        $correct_code_a = get_post_meta(get_the_ID(), $role . '_a', true);
        $correct_code_b = get_post_meta(get_the_ID(), $role . '_b', true);

        if ($inputs[$role] !== $correct_code_a && $inputs[$role] !== $correct_code_b) {
            $all_correct = false;
            break;
        }
    }

    if ($all_correct) {
        $redirect_url = $base_url . '/success/';
        wp_redirect(add_query_arg('qr', $qr_id, $redirect_url));
        exit;
    } else {
        $redirect_url = $base_url . '/error/';
        wp_redirect(add_query_arg('qr', $qr_id, $redirect_url));
        exit;
    }
}
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>

                <form method="post" action="" class="qr-code-form">
                    <input type="hidden" name="qr" value="<?php echo esc_attr($qr_id); ?>">

                    <!-- チーム選択のセレクトボックス -->
                    <div class="form-group">
                        <label for="team_select">チームを選択してください:</label>
                        <select id="team_select" name="selected_team" required>
                            <option value="" disabled selected>チームを選択</option>
                            <?php foreach ($team_names as $team_key => $team_name): ?>
                                <option value="<?php echo esc_attr($team_key); ?>"><?php echo esc_html($team_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 選択されたチームの役職ごとの入力欄を表示 -->
                    <?php foreach ($required_roles_teams as $team => $roles): ?>
                        <div class="team-roles" data-team="<?php echo esc_attr($team); ?>" style="display:none;">
                            <?php foreach ($roles as $role): ?>
                                <div class="form-group">
                                    <label for="input_<?php echo esc_attr($team); ?>_<?php echo esc_attr($role); ?>">
                                        <?php echo esc_html($role_names[$role]); ?>のコード (<?php echo esc_html($team_names[$team]); ?>):
                                    </label>
                                    <input type="text" id="input_<?php echo esc_attr($team); ?>_<?php echo esc_attr($role); ?>" name="input_<?php echo esc_attr($team); ?>_<?php echo esc_attr($role); ?>" required>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                    
                    <button type="submit" class="submit-btn">確認</button>
                </form>

                <script>
                    document.getElementById('team_select').addEventListener('change', function() {
                        var selectedTeam = this.value;

                        // すべてのチームの役職フィールドを非表示にし、requiredを解除
                        document.querySelectorAll('.team-roles').forEach(function(teamDiv) {
                            teamDiv.style.display = 'none';
                            teamDiv.querySelectorAll('input').forEach(function(input) {
                                input.removeAttribute('required');
                            });
                        });

                        // 選択されたチームの役職フィールドのみ表示し、requiredを追加
                        if (selectedTeam) {
                            var selectedTeamDiv = document.querySelector('.team-roles[data-team="' + selectedTeam + '"]');
                            if (selectedTeamDiv) {
                                selectedTeamDiv.style.display = 'block';
                                selectedTeamDiv.querySelectorAll('input').forEach(function(input) {
                                    input.setAttribute('required', 'required');
                                });
                            }
                        }
                    });
                </script>

            </div>
        </article>
    </main>
</div>




<style>
    /* スマートフォン用スタイル */
    body {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: #333;
        margin: 0;
        padding: 0;
        background: #fffffa;
    }

    .content-area {
        max-width: 480px;
        margin: 0 auto;
        padding: 20px;
    }

    .entry-title {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
    }

    .qr-code-form {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    .submit-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    /* PC表示用（最大幅で中央表示） */
    @media (min-width: 481px) {
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .content-area {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    }
    /* セレクトボックスのスタイル */
    select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 2px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
        color: #333;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    /* セレクトボックスのホバー時のスタイル */
    select:hover {
        border-color: #888;
    }

    /* セレクトボックスのフォーカス時のスタイル */
    select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* 矢印アイコンのカスタマイズ */
    select::after {
        content: '\25BC';
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    /* セレクトボックスのラベルのスタイル */
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

</style>

<?php
wp_footer();
?>
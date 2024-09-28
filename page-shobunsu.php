<?php
/*
Template Name: QR Code Role-based Validation Quiz
*/

wp_head();

// チームと役職のパターンを定義
$qr_patterns = [
    '001' => ['team01' => ['role01', 'role02'], 'team02' => ['role01', 'role03'], 'team03' => ['role02', 'role03']],
    '002' => ['team01' => ['role01', 'role02'], 'team02' => ['role01', 'role03'], 'team03' => ['role02', 'role03']],
    // 他のQRコードパターンをここに追加
];

// 役職名の定義（カスタムフィールドから取得）
$role_names = [
    'role01' => get_post_meta(get_the_ID(), 'role01', true) ?: '役職1',
    'role02' => get_post_meta(get_the_ID(), 'role02', true) ?: '役職2',
    'role03' => get_post_meta(get_the_ID(), 'role03', true) ?: '役職3'
];

// パラメータの取得
$qr_id = isset($_GET['qr']) ? sanitize_text_field($_GET['qr']) : '';

// ベースURLの設定
$base_url = home_url('shobunsu');

if (!isset($qr_patterns[$qr_id])) {
    wp_die('Invalid QR code');
}

$required_roles_teams = $qr_patterns[$qr_id];

// 送信されたフォームの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputs = [];
    $all_correct = true;

    foreach ($required_roles_teams as $team => $roles) {
        foreach ($roles as $role) {
            $input_key = 'input_' . $team . '_' . $role;
            $inputs[$team][$role] = isset($_POST[$input_key]) ? sanitize_text_field($_POST[$input_key]) : '';
            
            $correct_code_a = get_post_meta(get_the_ID(), $role . '_a', true);
            $correct_code_b = get_post_meta(get_the_ID(), $role . '_b', true);
            
            if ($inputs[$team][$role] !== $correct_code_a && $inputs[$team][$role] !== $correct_code_b) {
                $all_correct = false;
                break 2; // 正解でない場合はループを終了
            }
        }
    }

    if ($all_correct) {
        // 正解の場合、成功ページにリダイレクト
        $redirect_url = $base_url . '/success/';
        wp_redirect(add_query_arg('qr', $qr_id, $redirect_url));
        exit;
    } else {
        // 不正解の場合、エラーページにリダイレクト
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
                    
                    <?php foreach ($required_roles_teams as $team => $roles): ?>
                        <h3><?php echo esc_html($team); ?>の入力</h3>
                        <?php foreach ($roles as $role): ?>
                            <div class="form-group">
                                <label for="input_<?php echo esc_attr($team); ?>_<?php echo esc_attr($role); ?>">
                                    <?php echo esc_html($role_names[$role]); ?>のコード (<?php echo esc_html($team); ?>):
                                </label>
                                <input type="text" id="input_<?php echo esc_attr($team); ?>_<?php echo esc_attr($role); ?>" name="input_<?php echo esc_attr($team); ?>_<?php echo esc_attr($role); ?>" required>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    
                    <button type="submit" class="submit-btn">確認</button>
                </form>
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
</style>

<?php
wp_footer();
?>
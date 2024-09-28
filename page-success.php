<?php
/*
Template Name: Success Page
*/

wp_head();

// QRコードパラメータの取得
$qr_id = isset($_GET['qr']) ? sanitize_text_field($_GET['qr']) : '';

// カスタムフィールドから鍵の番号を取得（10パターン）
$key_numbers = [];
for ($i = 1; $i <= 10; $i++) {
    $key_field = 'key' . str_pad($i, 3, '0', STR_PAD_LEFT);
    $key_numbers[$i] = get_post_meta(get_the_ID(), $key_field, true);
}

// QRコードに応じた鍵の番号を選択
$displayed_key = '';
if ($qr_id && isset($key_numbers[intval($qr_id)])) {
    $displayed_key = $key_numbers[intval($qr_id)];
} else {
    $displayed_key = '鍵の番号が見つかりません';
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

                <p>正解です！おめでとうございます。</p>
                <p>鍵の番号: <?php echo esc_html($displayed_key); ?></p>
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
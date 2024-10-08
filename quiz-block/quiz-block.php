<?php
/*
Plugin Name: Quiz Blocks
Plugin URI: https://example.com/  // オプション
Description: A plugin to add custom quiz blocks to the WordPress editor.
Version: 1.0
Author: Your Name
Author URI: https://example.com/  // オプション
Text Domain: quiz-bloks  // オプション
Domain Path: /languages  // オプション
*/

// ブロックの登録
function register_quiz_blocks() {
    // 選択式クイズブロック
    register_block_type('my-quiz/multiple-choice', array(
        'editor_script' => 'quiz-block-editor',
        'editor_style' => 'quiz-block-editor-style',
        'attributes' => array(
            'question' => array('type' => 'string'),
            'choices' => array('type' => 'array'),
            'correctAnswer' => array('type' => 'number'),
            'correctMessage' => array('type' => 'string'),
            'incorrectMessage' => array('type' => 'string'),
            'nextQuizId' => array('type' => 'string'),
        ),
        'render_callback' => 'render_multiple_choice_quiz'
    ));

    // 入力式クイズブロック
    register_block_type('my-quiz/text-input', array(
        'editor_script' => 'quiz-block-editor',
        'editor_style' => 'quiz-block-editor-style',
        'attributes' => array(
            'question' => array('type' => 'string'),
            'correctAnswer' => array('type' => 'string'),
            'correctMessage' => array('type' => 'string'),
            'incorrectMessage' => array('type' => 'string'),
            'nextQuizId' => array('type' => 'string'),
        ),
        'render_callback' => 'render_text_input_quiz'
    ));
}
add_action('init', 'register_quiz_blocks');

// スクリプトとスタイルの登録
function enqueue_quiz_block_assets() {
    wp_enqueue_script(
        'quiz-block-editor',
        plugins_url('build/index.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . 'build/index.js'),
        true
    );

    wp_enqueue_style(
        'quiz-block-editor-style',
        plugins_url('build/editor.css', __FILE__),
        array('wp-edit-blocks')
    );

    wp_enqueue_script(
        'quiz-frontend',
        plugins_url('js/quiz-frontend.js', __FILE__),
        array('jquery'),
        '1.0.0',
        true
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_quiz_block_assets');

// 選択式クイズのレンダリング
function render_multiple_choice_quiz($attributes) {
    $question = $attributes['question'];
    $choices = $attributes['choices'];
    $quiz_id = uniqid('quiz-');
    
    ob_start();
    ?>
    <div class="quiz-block multiple-choice" id="<?php echo esc_attr($quiz_id); ?>" 
         data-correct="<?php echo esc_attr($attributes['correctAnswer']); ?>"
         data-next-quiz="<?php echo esc_attr($attributes['nextQuizId']); ?>">
        <div class="quiz-question"><?php echo esc_html($question); ?></div>
        <div class="quiz-choices">
            <?php foreach ($choices as $index => $choice): ?>
                <button class="quiz-choice" data-choice="<?php echo esc_attr($index); ?>">
                    <?php echo esc_html($choice); ?>
                </button>
            <?php endforeach; ?>
        </div>
        <div class="quiz-result correct" style="display: none;">
            <?php echo wp_kses_post($attributes['correctMessage']); ?>
        </div>
        <div class="quiz-result incorrect" style="display: none;">
            <?php echo wp_kses_post($attributes['incorrectMessage']); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// 入力式クイズのレンダリング
function render_text_input_quiz($attributes) {
    $question = $attributes['question'];
    $quiz_id = uniqid('quiz-');
    
    ob_start();
    ?>
    <div class="quiz-block text-input" id="<?php echo esc_attr($quiz_id); ?>"
         data-correct="<?php echo esc_attr($attributes['correctAnswer']); ?>"
         data-next-quiz="<?php echo esc_attr($attributes['nextQuizId']); ?>">
        <div class="quiz-question"><?php echo esc_html($question); ?></div>
        <div class="quiz-input">
            <input type="text" class="quiz-answer">
            <button class="quiz-submit">回答する</button>
        </div>
        <div class="quiz-result correct" style="display: none;">
            <?php echo wp_kses_post($attributes['correctMessage']); ?>
        </div>
        <div class="quiz-result incorrect" style="display: none;">
            <?php echo wp_kses_post($attributes['incorrectMessage']); ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
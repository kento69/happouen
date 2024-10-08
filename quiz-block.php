<?php
/**
 * Plugin Name:       Quiz-block
 * Plugin URI:        http://demo.kentoshoji.com/happouen
 * Description:       Let&#39;s play quiz game
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Version:           0.1.0
 * Author:            shoji
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       quiz-block
 *
 * @package QuizBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function quiz_block_quiz_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'quiz_block_quiz_block_block_init' );

// ブロックの登録
function quiz_block_quiz_block_block_init() {
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
add_action('init', 'quiz_block_quiz_block_block_init');

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


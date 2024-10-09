// js/quiz-frontend.js
jQuery(document).ready(function($) {
    // 選択式クイズの処理
    $('.quiz-block.multiple-choice .quiz-choice').click(function() {
        const $block = $(this).closest('.quiz-block');
        const choice = parseInt($(this).data('choice'));
        const correctAnswer = parseInt($block.data('correct'));
        const nextQuizId = $block.data('next-quiz');

        if (choice === correctAnswer) {
            $block.find('.quiz-choices').hide();
            $block.find('.quiz-result.correct').show();
            
            if (nextQuizId) {
                const $nextQuiz = $('#' + nextQuizId);
                if ($nextQuiz.length) {
                    setTimeout(() => {
                        $block.hide();
                        $nextQuiz.show();
                    }, 1500);
                }
            }
        } else {
            $block.find('.quiz-result.incorrect').show();
        }
    });

    // 入力式クイズの処理
    $('.quiz-block.text-input .quiz-submit').click(function() {
        const $block = $(this).closest('.quiz-block');
        const userAnswer = $block.find('.quiz-answer').val().trim();
        const correctAnswer = $block.data('correct');
        const nextQuizId = $block.data('next-quiz');

        if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
            $block.find('.quiz-input').hide();
            $block.find('.quiz-result.correct').show();
            
            if (nextQuizId) {
                const $nextQuiz = $('#' + nextQuizId);
                if ($nextQuiz.length) {
                    setTimeout(() => {
                        $block.hide();
                        $nextQuiz.show();
                    }, 1500);
                }
            }
        } else {
            $block.find('.quiz-result.incorrect').show();
        }
    });

    // 初期状態で後続のクイズを非表示にする
    $('.quiz-block').each(function() {
        const id = $(this).attr('id');
        if (id && $('.quiz-block[data-next-quiz="' + id + '"]').length) {
            $(this).hide();
        }
    });
});

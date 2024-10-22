<?php get_header();?>

<body>
    <div class="quiz-container">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <p>木下家店長「怪しい奴！うちは江戸時代から代々続く老舗の陶器屋だと知ってるのか？冷やかしなら出ていきな！」</p>
        </div>
        
        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:　買い物しますよ</button>
                <button class="option-button" data-value="2">2:　聞き込みさせてください</button>
            </div>
            <button class="submit-button" id="submitQuiz" disabled>解答する</button>
            <div class="feedback hidden" id="quizFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クイズの設定
            const quizConfig = {
                correctAnswer: '1',
                feedbackCorrect: {
                    text: '木下屋店長「おっとお客さんかい、失礼だった！是非何か見ていってくんなせえ！」よし、店に入ろう！',
                },
                feedbackIncorrect: {
                    text: '木下屋店長「モノも買わねえ奴には何も教えてやらん！」',
                }
            };

            // 選択肢の状態管理
            const quizSection = document.getElementById('quiz');
            const options = quizSection.querySelectorAll('.option-button');
            const submitButton = document.getElementById('submitQuiz');
            let selectedAnswer = null;

            // 選択肢のクリックイベント
            options.forEach(button => {
                button.addEventListener('click', function() {
                    options.forEach(btn => btn.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedAnswer = this.dataset.value;
                    submitButton.disabled = false;
                });
            });

            // フィードバック表示用の関数
            function renderFeedback(feedbackDiv, feedback, isCorrect) {
                let feedbackContent = '';
                
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text && feedback.text.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text}</p>`;
                }
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text01 && feedback.text01.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text01}</p>`;
                }
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text02 && feedback.text02.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text02}</p>`;
                }
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text03 && feedback.text03.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text03}</p>`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img class="feedback-image" src="${feedback.image}" alt="フィードバック画像">`;
                }
                
                
                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;
                feedbackDiv.classList.remove('hidden');
            }

            // 解答処理
            submitButton.addEventListener('click', function() {
                const isCorrect = selectedAnswer === quizConfig.correctAnswer;
                const feedback = isCorrect ? quizConfig.feedbackCorrect : quizConfig.feedbackIncorrect;

                // ボタンと選択肢を非活性化
                this.disabled = true;
                options.forEach(button => {
                    button.classList.add('disabled');
                    button.disabled = true;
                });

                // フィードバック表示
                const feedbackDiv = document.getElementById('quizFeedback');
                renderFeedback(feedbackDiv, feedback, isCorrect);
            });
        });
    </script>
</body>
</html>
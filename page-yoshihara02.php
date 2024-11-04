<?php get_header();?>

<body>
    <div class="quiz-container -yoshihara">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara01.png" alt="イントロ画像" />
        </div>

        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <p class="question-text">Resident: "Hey! W-who are you people!?"</p>
            <div class="quiz-options">
                <button class="option-button" data-value="1">1: Nobody. We were just wondering what that smell was.</button>
                <button class="option-button" data-value="2">2. Sorry! We're friends of Kazukiyo-san, and we were wondering what that smell was.</button>
            </div>
            <button class="submit-button" id="submitQuiz" disabled>Answer</button>
            <div class="feedback hidden" id="quizFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クイズの設定
            const quizConfig = {
                correctAnswer: '2',
                feedbackCorrect: {
                    text01: 'Resident: "Oh, you\'re friends of Kazukiyo-san? Welcome! That smell is the vinegar juice Kazukiyo-san taught me to make. I\'ll give you the recipe if you\'d like.',
                    text02: 'Resident: "Please tell Kazukiyo-san that we love his vinegar! ',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara02.png',
                    file: '<?php echo get_template_directory_uri(); ?>/assets/images/recipe/royalapple.png'
                },
                feedbackIncorrect: {
                    text: 'Resident: "Nobody?! Bandits more like. You can\'t barge into my house without permission! Get out, get out!"',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara02.png'
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
                
                if (feedback.text01 && feedback.text01.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text01}</p>`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img class="feedback-image" src="${feedback.image}" alt="フィードバック画像">`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.file && feedback.file.trim() !== '') {
                    feedbackContent += `<a href="${feedback.file}" download>You've obtained the vinegar juice recipe "Royal Apple".</a>`;
                }
                
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text02 && feedback.text02.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text02}</p>`;
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
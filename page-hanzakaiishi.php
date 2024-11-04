<?php get_header();?>

<body>
    <div class="quiz-container -ishi">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <p>"Here is the boundary stone. During the Edo period, it was used as the border between the Kurume and Yanagawa Districts. At that time, crossing the district border was like crossing into another country. Very dangerous. That is why the roads were designed in a zigzag manner to hide from attacks."</p>
        </div>
        
        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <p class="question-text">Oh no, a little girl is crying.<br>"Waah, waah."</p>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/girl03.png" alt="イントロ画像" />
            <div class="quiz-options">
                <button class="option-button" data-value="1">1 Approach her and ask what's wrong.</button>
                <button class="option-button" data-value="2">2 Ignore her because you're busy.</button>
            </div>
            <button class="submit-button" id="submitQuiz" disabled>Answer</button>
            <div class="feedback hidden" id="quizFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クイズの設定
            const quizConfig = {
                correctAnswer: '1',
                feedbackCorrect: {
                    text: 'You: "Hi there. What\'s wrong? What\'s your name?"',
                    text01: 'Girl: "I\'m Ogin. I got lost and can\'t find my way home..."',
                    text02: 'You: "You poor child! I\'ll help you find your home. Is there any kind of landmark you can tell me about?"',
                    text03: 'Girl: "Umm...It\'s an old house between the vinegar shop and the washi paper store..."',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/girl01.png',
                },
                feedbackIncorrect: {
                    text: 'Girl: "Waah, waah."',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/girl03.png',
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
<?php get_header();?>
<body>
    <div class="quiz-container -monpe">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/monpe01.png" alt="イントロ画像" />
            <!-- <h1>クイズタイトル</h1> -->
            <p>Monpe Shop Manager: "Well hello! I've noticed you staring at my Monpe Shop. Do you know what a Monpe Shop is?</p>
        </div>

        <!-- 選択式クイズセクション -->
        <div class="quiz-section" id="multipleChoiceQuiz">
            <div class="quiz-options">
                <button class="option-button" data-value="1">1. Yes, I know.</button>
                <button class="option-button" data-value="2">2. No, I don't think so. What's a "Monpe" shop?</button>
            </div>
            <button class="submit-button" id="submitMultipleChoice" disabled>Answer</button>
            <div class="feedback hidden" id="multipleChoiceFeedback"></div>
        </div>

        <!-- 入力式クイズセクション -->
        <div class="quiz-section hidden" id="textInputQuiz">
            <input type="text" class="text-input" id="textAnswer" placeholder="Enter the password.">
            <button class="submit-button" id="submitTextInput">Answer</button>
            <div class="feedback hidden" id="textInputFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 選択式クイズの設定
            const multipleChoiceQuiz = {
                correctAnswer: '1',
                feedbackCorrect: {
                    text: 'Monpe Shop Manager: "Oh Really? Then tell me, what year were monpe trousers created? Come on, tell me." ',
                },
                feedbackIncorrect: {
                    text: '"Monpe" are trousers popularized in 1942 as an informal uniform for work. Thanks to their warmth and easy mobility, they\'ve become popular clothing for everyday use. They are a perfect blend of Japanese and Western clothing! ',
                }
            };
            
            // 入力式クイズの設定
            const textInputQuiz = {
                correctAnswer: '1942',
                feedbackCorrect: {
                    text: 'Monpe Shop Manager: "Impressive! You do seem to know about Japanese History. What\'s that? You\'re friends of Shobunsu? The bacteria released whenever Shobunsu makes vinegar always turn the exterior walls black." ',
                    file: '<?php echo get_template_directory_uri(); ?>/assets/images/recipe/citrusbreeze.png',
                },
                feedbackIncorrect: {
                    text: '"Oh no! I should have just answered honestly to the first question..."',
                }
            };

            // 選択肢のクリックイベント
            const optionButtons = document.querySelectorAll('.option-button');
            let selectedAnswer = null;

            optionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    optionButtons.forEach(btn => btn.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedAnswer = this.dataset.value;
                    document.getElementById('submitMultipleChoice').disabled = false;
                });
            });

            // 選択式クイズの解答処理
            document.getElementById('submitMultipleChoice').addEventListener('click', function() {
                const feedbackDiv = document.getElementById('multipleChoiceFeedback');
                const isCorrect = selectedAnswer === multipleChoiceQuiz.correctAnswer;
                const feedback = isCorrect ? multipleChoiceQuiz.feedbackCorrect : multipleChoiceQuiz.feedbackIncorrect;

                let feedbackContent = '';
                
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text && feedback.text.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text}</p>`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img class="feedback-image" src="${feedback.image}" alt="フィードバック画像">`;
                }

                
                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;

                if (isCorrect) {
                    // 次の入力式クイズを表示
                    document.getElementById('textInputQuiz').classList.remove('hidden');
                }
            });

            // 入力式クイズの解答処理
            document.getElementById('submitTextInput').addEventListener('click', function() {
                const userAnswer = document.getElementById('textAnswer').value;
                const feedbackDiv = document.getElementById('textInputFeedback');
                const isCorrect = userAnswer === textInputQuiz.correctAnswer;
                const feedback = isCorrect ? textInputQuiz.feedbackCorrect : textInputQuiz.feedbackIncorrect;

                let feedbackContent = '';
                
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text && feedback.text.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text}</p>`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img class="feedback-image" src="${feedback.image}" alt="フィードバック画像">`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.file && feedback.file.trim() !== '') {
                    feedbackContent += `<a href="${feedback.file}" download>You've obtained the vinegar juice recipe "Citrus Breeze".</a>`;
                }
                
                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;
            });
        });
    </script>
</body>
</html>
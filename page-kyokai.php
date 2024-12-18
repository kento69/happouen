<?php get_header();?>

<body>
    <div class="quiz-container -kyokai">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara01.png" alt="イントロ画像" />
            <p>Parent: "Oh dear...It seems my child got lost again...Excuse me! Have you seen a little girl? You have? What's her name?"</p>
        </div>

        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <p class="question-text">I feel like I saw a little girl around the boundary marker stone...</p>
            <div class="quiz-input">
                <input type="text" 
                       class="text-input" 
                       id="answerInput" 
                       placeholder="Input Girl's Name"
                       autocomplete="off">
                <button class="submit-button" id="submitQuiz" disabled>Answer</button>
            </div>
            <div class="feedback hidden" id="quizFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クイズの設定
            const quizConfig = {
                // 正解の設定（複数の正解パターンに対応）
                correctAnswers: [
                    'GIN',
                ],
                // 正解判定時の大文字小文字の区別
                caseSensitive: false,
                // 正解時のフィードバック
                feedbackCorrect: {
                    text: 'Parent: "Thank you so much for bringing her home! Ogin, I have told you many times NOT to go near the boundary marker stone! Do you want to be spirited away by the ghosts that haunt the roads?"',
                    text01: 'Ogin: "Waaah!"(continues crying)',
                    text02: 'Since ancient times, parents have warned their children about ghosts which haunt the roads and forests beyond the district as a way to keep them from wandering off.',
                    text03: '"Kazukiyo-san wants my opinion on whether to mass produce his vinegar?...That makes sense. He is always thinking about his neighbors\' needs. He even goes out of his way every year to help clean the Hiyoshi Shrine. Of course, he\'d appreciate the opinions of the local people."',
                    text04: '"I like the vinegar the way it is! I don\'t want it to change!"',
                    text05: '"Haha! Kids are so honest, aren\'t they? But it would be sad if the vinegar used in the school lunches changed flavor. Mass produced products just aren\'t the same as locally made goods, you know?',
                    file: '<?php echo get_template_directory_uri(); ?>/assets/images/recipe/gingerbloom.png'

                },
                // 不正解時のフィードバック
                feedbackIncorrect: {
                    text: 'Hmm... that\'s a different child. I just hope she hasn\'t wandered off toward the boundary marker stone and gotten lost.',
                    text01: 'the boundary marker stone... maybe I should go check it out.',
                }
            };

            // 入力フィールドと送信ボタンの取得
            const answerInput = document.getElementById('answerInput');
            const submitButton = document.getElementById('submitQuiz');

            // 入力チェック
            answerInput.addEventListener('input', function() {
                submitButton.disabled = this.value.trim() === '';
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
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text04 && feedback.text04.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text04}</p>`;
                }
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text05 && feedback.text05.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text05}</p>`;
                }
                
                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img class="feedback-image" src="${feedback.image}" alt="フィードバック画像">`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.file && feedback.file.trim() !== '') {
                    feedbackContent += `<a href="${feedback.file}" download>You've obtained the vinegar juice recipe "Green Rush".</a>`;
                }
                
                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;
                feedbackDiv.classList.remove('hidden');
            }

            // 正解判定関数
            function checkAnswer(userAnswer, correctAnswers, caseSensitive) {
                const processAnswer = (answer) => caseSensitive ? answer : answer.toLowerCase();
                const processedUserAnswer = processAnswer(userAnswer.trim());
                const processedCorrectAnswers = correctAnswers.map(answer => processAnswer(answer.trim()));
                
                return processedCorrectAnswers.includes(processedUserAnswer);
            }

            // 解答処理
            submitButton.addEventListener('click', function() {
                const userAnswer = answerInput.value;
                const isCorrect = checkAnswer(userAnswer, quizConfig.correctAnswers, quizConfig.caseSensitive);
                const feedback = isCorrect ? quizConfig.feedbackCorrect : quizConfig.feedbackIncorrect;

                // 入力フィールドと送信ボタンを非活性化
                answerInput.disabled = true;
                answerInput.classList.add('disabled');
                submitButton.disabled = true;

                // フィードバック表示
                const feedbackDiv = document.getElementById('quizFeedback');
                renderFeedback(feedbackDiv, feedback, isCorrect);
            });

            // Enterキーでの送信対応
            answerInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !submitButton.disabled) {
                    submitButton.click();
                }
            });
        });
    </script>
</body>
</html>
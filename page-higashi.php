<?php get_header();?>

<body>
    <div class="quiz-container">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara01.png" alt="イントロ画像" />
            <p>東さん「おいあんた・・うちの犬見なかったかい？え、見た？名前は！？」</p>
        </div>

        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <!-- <p class="question-text">少女の名前を入力してください</p> -->
            <div class="quiz-input">
                <input type="text" 
                       class="text-input" 
                       id="answerInput" 
                       placeholder="犬の名前を入力してください"
                       autocomplete="off">
                <button class="submit-button" id="submitQuiz" disabled>解答する</button>
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
                    'SOFIA',
                ],
                // 正解判定時の大文字小文字の区別
                caseSensitive: false,
                // 正解時のフィードバック
                feedbackCorrect: {
                    text: '東さん「おおお、ソフィア！！！」',
                    text01: 'ソフィア「ワンワンワン」',
                    text02: '東さん「あなた達、うちが明治時代に錨を作ってたなんてよく知ってたねえ」',
                    text03: '東さん「高橋さんがねぇ・・ま、詳しいことは分からんが、俺はあの人がどんな選択をしてもついていくよ。なるべくならお酢の味は変えないで欲しいけどなあハハハ」',
                },
                // 不正解時のフィードバック
                feedbackIncorrect: {
                    text: '残念！もう一度チャレンジする場合は、ページを再読み込みしてください。',
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
                
                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img class="feedback-image" src="${feedback.image}" alt="フィードバック画像">`;
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
<!DOCTYPE html>
<html>
<head>
    <style>
        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 100px 20px;
            font-family: sans-serif;
        }
        .quiz-container p,
        .quiz-container a,
        .quiz-container input,
        .quiz-container button {
            font-size: 20px;
        }
        .intro {
            margin-bottom: 40px;
        }
        .intro, .quiz-section {
            margin-bottom: 30px;
        }
        .quiz-input {
            margin: 20px 0;
        }
        .text-input {
            width: 100%;
            max-width: 400px;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .text-input:focus {
            outline: none;
            border-color: #007bff;
        }
        .text-input.disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }
        .submit-button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .hidden {
            display: none;
        }
        .feedback {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .feedback.correct {
            background: #d4edda;
            color: #155724;
        }
        .feedback.incorrect {
            background: #f8d7da;
            color: #721c24;
        }
        .feedback-text {
            margin-bottom: 15px;
        }
        .feedback-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <p>緒方さん「弱ったなあ・・今日注射をうける女の子が逃げちゃって・・えっ、そこのあんた、女の子を見かけた？なんて名前だい？」</p>
        </div>

        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <!-- <p class="question-text">少女の名前を入力してください</p> -->
            <div class="quiz-input">
                <input type="text" 
                       class="text-input" 
                       id="answerInput" 
                       placeholder="少女の名前を入力してください"
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
                    'Anna',
                ],
                // 正解判定時の大文字小文字の区別
                caseSensitive: false,
                // 正解時のフィードバック
                feedbackCorrect: {
                    text: '緒方さん「連れてきてくれてありがとう、ほら痛くないからね」',
                    text01: 'お銀「あれっ、本当だ、痛くない！」',
                    text02: '緒方さん「あなた達、知らない人たちだけど優しいねえ」',
                    text03: '緒方医師「ほう高橋さんがねぇ・・あの人は、日吉神社の掃除をやるくらい、地元とのつながりを大切にしてる人だ。そりゃ地元の人たちの声も聴きたいんだろうねぇ」',
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
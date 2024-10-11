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
        .intro img {
            display: block;
            width: 60%;
            margin: 0 auto;
            text-align: center;
        }
        .quiz-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 20px 0;
        }
        .option-button {
            padding: 10px 20px;
            border: 2px solid #ddd;
            border-radius: 5px;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }
        .option-button:hover {
            background: #f5f5f5;
        }
        .option-button.selected {
            border-color: #007bff;
            background: #e7f1ff;
        }
        .option-button.disabled {
            cursor: not-allowed;
            opacity: 0.6;
            pointer-events: none;
        }
        .submit-button {
            padding: 16px 32px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
            margin: 40px 0 10px;
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
            max-width: 60%;
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
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/dog04.webp" alt="イントロ画像" />
            <p>ここは1883年に建てられた中村家住宅。戦前までは生活雑貨を取り扱っていたが、戦後は紙専門店として現在も営業。村や町の中心部で、人々の目に多く触れるところだったから、高札場が設けられていた。</p>
        </div>

        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <p class="question-text">おや、犬がいるぞ。</p>
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:　触る</button>
                <button class="option-button" data-value="2">2:　やめる</button>
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
                    text: 'どれどれ、首輪（写真で見せる。錨っぽいデザイン）がついている・・名前は「SOFIA」か。逃げ出しちゃったのかな。なにかヒントになるものは・・',
                },
                feedbackIncorrect: {
                    text: '犬「くうーん、くうーん」',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/dog04.webp'
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
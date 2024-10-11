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
        .quiz-container p {
            font-size: 24px;
        }
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
        .intro img, .quiz-section img {
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
            <p>ここに藩境石・・江戸時代には久留米藩と柳河藩の境目として用いられていた。当時の藩境は、国境のようにぴり付いてた場所でもあった。だから、道をジグザグにして攻撃から身を隠せるような作りになっていた。</p>
        </div>
        
        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <p class="question-text">おや、少女が泣いている。「えーんえーん」</p>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/girl03.png" alt="イントロ画像" />
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:声をかける</button>
                <button class="option-button" data-value="2">2:忙しいので無視</button>
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
                    text: '君、お名前は？',
                    text01: '少女「アタイはお銀。おうちが分からなくなっちゃたの・・」',
                    text02: 'まいったな・・何か目印みたいなものはないかな？',
                    text03: '少女「ええっと・・お酢のお店と、和紙屋さんの間の古いおうちなんだけど・・」',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/girl01.png'
                },
                feedbackIncorrect: {
                    text: '少女「えーんええーん」',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/girl03.png'
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
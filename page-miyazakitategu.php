<?php get_header();?>

<body>
    <div class="quiz-container -tategu">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/miyazaki01.png" alt="イントロ画像" />
            <p>Miyazaki Furnishings was founded in 1927. Their skillful workmanship and user-friendly designs have made them popular not only with traditional Japanese architects but with modern craftsmanship such as cafes and trains. Although they've adopted many modern projects, they've continued to pass down their ancestral crafting techniques to the present day. </p>
        </div>

        <!-- 第1問 選択式クイズセクション -->
        <div class="quiz-section" id="firstQuiz">
            <p class="question-text">"Stop! Who are you? You look suspicious."</p>
            <div class="quiz-options">
                <button class="option-button" data-value="1">"Sorry, we didn't mean to act suspicious. We were just admiring your woodwork."</button>
                <button class="option-button" data-value="2">"We're not acting suspicious! How rude!"</button>
            </div>
            <button class="submit-button" id="submitFirstQuiz" disabled>Answer</button>
            <div class="feedback hidden" id="firstQuizFeedback"></div>
        </div>

        <!-- 第2問 選択式クイズセクション -->
        <div class="quiz-section hidden" id="secondQuiz">
            <div class="quiz-options">
                <button class="option-button" data-value="1">Cedar</button>
                <button class="option-button" data-value="2">Oak</button>
                <button class="option-button" data-value="3">Teak</button>
            </div>
            <button class="submit-button" id="submitSecondQuiz" disabled>Answer</button>
            <div class="feedback hidden" id="secondQuizFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クイズの設定
            const quizConfig = {
                first: {
                    correctAnswer: '1',
                    feedbackCorrect: {
                        text: 'Hmph...Well, Okawa is a woodworking town and anyone who loves woodworking is known to be trustworthy. Alright, tell me this, what type of wood is used for the exterior of this building?"',
                    },
                    feedbackIncorrect: {
                        text: '"Ha! Get outta here!" ',
                    }
                },
                second: {
                    correctAnswer: '1',
                    feedbackCorrect: {
                        text: '"You...you got it right! Cedar wood is native to Japan and is often used for the exterior of houses. It\'s durable and lasts a long time. You are quite the wood expert!" "What that? Shobunzu is worried about mass marketing?" "I\'m only a joiner, so I can\'t say much about vinegar, but I\'ll tell you this: liquids always taste better when they are made in wooden barrels than by machines. At least in my opinion."',
                        file: '<?php echo get_template_directory_uri(); ?>/assets/images/recipe/greenrush.png'
                    },
                    feedbackIncorrect: {
                        text: '"Ha! Get outta here!"',
                    }
                }
            };

            // クイズセクションごとの選択肢の状態管理
            function initializeQuizSection(quizId) {
                const section = document.getElementById(quizId);
                const options = section.querySelectorAll('.option-button');
                const submitButton = section.querySelector('.submit-button');
                let selectedAnswer = null;

                options.forEach(button => {
                    button.addEventListener('click', function() {
                        options.forEach(btn => btn.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedAnswer = this.dataset.value;
                        submitButton.disabled = false;
                    });
                });

                return { options, submitButton, getSelectedAnswer: () => selectedAnswer };
            }

            // 第1問の初期化
            const firstQuiz = initializeQuizSection('firstQuiz');

            // 第2問の初期化
            const secondQuiz = initializeQuizSection('secondQuiz');

            // 第1問の解答処理
            firstQuiz.submitButton.addEventListener('click', function() {
                const isCorrect = firstQuiz.getSelectedAnswer() === quizConfig.first.correctAnswer;
                const feedback = isCorrect ? quizConfig.first.feedbackCorrect : quizConfig.first.feedbackIncorrect;

                // ボタンと選択肢を非活性化
                this.disabled = true;
                firstQuiz.options.forEach(button => {
                    button.classList.add('disabled');
                    button.disabled = true;
                });

                // フィードバック表示
                const feedbackDiv = document.getElementById('firstQuizFeedback');
                // フィードバックの内容を構築
                let feedbackContent = '';
                
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text && feedback.text.trim() !== '') {
                    feedbackContent += `<p>${feedback.text}</p>`;
                }
                
                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img src="${feedback.image}" alt="フィードバック画像" style="max-width: 100%;">`;
                }
                
                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;

                // 正解の場合、第2問を表示
                if (isCorrect) {
                    document.getElementById('secondQuiz').classList.remove('hidden');
                }
            });

            // 第2問の解答処理
            secondQuiz.submitButton.addEventListener('click', function() {
                const isCorrect = secondQuiz.getSelectedAnswer() === quizConfig.second.correctAnswer;
                const feedback = isCorrect ? quizConfig.second.feedbackCorrect : quizConfig.second.feedbackIncorrect;

                // ボタンと選択肢を非活性化
                this.disabled = true;
                secondQuiz.options.forEach(button => {
                    button.classList.add('disabled');
                    button.disabled = true;
                });

                // フィードバック表示
                const feedbackDiv = document.getElementById('secondQuizFeedback');
                // フィードバックの内容を構築
                let feedbackContent = '';
                
                // テキストが存在し、空でない場合のみ追加
                if (feedback.text && feedback.text.trim() !== '') {
                    feedbackContent += `<p>${feedback.text}</p>`;
                }
                
                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.image && feedback.image.trim() !== '') {
                    feedbackContent += `<img src="${feedback.image}" alt="フィードバック画像" style="max-width: 100%;">`;
                }

                // 画像URLが存在し、空でない場合のみ追加
                if (feedback.file && feedback.file.trim() !== '') {
                    feedbackContent += `<a href="${feedback.file}" download>You've obtained the vinegar juice recipe "Green Rush".</a>`;
                }

                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;
            });
        });
    </script>
</body>
</html>
<?php get_header();?>

<body>
    <div class="quiz-container">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/miyazaki01.png" alt="イントロ画像" />
            <p>宮崎建具の創業は1927年。木を自在に操り、使いやすいデザインをモットーに、伝統的な建具だけでなく、カフェや豪華観光列車の内装まで手掛けている。常に新しいものづくりにチャレンジしながら、職人の技術を今に伝えている。</p>
        </div>

        <!-- 第1問 選択式クイズセクション -->
        <div class="quiz-section" id="firstQuiz">
            <p class="question-text">当時の店主「おいお前、怪しいな」</p>
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:　怪しいです</button>
                <button class="option-button" data-value="2">2:　怪しくないです</button>
            </div>
            <button class="submit-button" id="submitFirstQuiz" disabled>解答する</button>
            <div class="feedback hidden" id="firstQuizFeedback"></div>
        </div>

        <!-- 第2問 選択式クイズセクション -->
        <div class="quiz-section hidden" id="secondQuiz">
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:　スギ</button>
                <button class="option-button" data-value="2">2:　オーク</button>
                <button class="option-button" data-value="3">3:　チーク</button>
            </div>
            <button class="submit-button" id="submitSecondQuiz" disabled>解答する</button>
            <div class="feedback hidden" id="secondQuizFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クイズの設定
            const quizConfig = {
                first: {
                    correctAnswer: '2',
                    feedbackCorrect: {
                        text: '「ふんっ・・この大川は木工の町、木を愛する人間なら信用できるってもんよ。よし、この建物の外壁に使われている木材の種類をあててみな！」',
                    },
                    feedbackIncorrect: {
                        text: '当時の店主「そうだろう！？俺は鼻がきくんだ」',
                    }
                },
                second: {
                    correctAnswer: '1',
                    feedbackCorrect: {
                        text: '「せ、正解だ・・！スギは日本原産の木材で、内装や外壁にも用いられ、長持ちするんだ。さてはあんた、相当な木力の持ち主だな？」「なに？庄分酢の旦那が悩んでる？」「俺は建具だから、詳しいことは言えんが、やはり機械で作ったもんより、木の樽で作ったもんのほうが美味しいぜ」',
                    },
                    feedbackIncorrect: {
                        text: '「この大川は木工の町、木のことを何も知れねぇやつはよそ者にちげぇねぇ。やっぱり怪しいやつだ。どっか行きなっ！」',
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
                
                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;
            });
        });
    </script>
</body>
</html>
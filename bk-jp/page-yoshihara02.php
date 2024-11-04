<?php get_header();?>

<body>
    <div class="quiz-container">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara01.png" alt="イントロ画像" />
            <p>ここは柳川藩小保町の別当職を代々務め、のちに蒲池組の大庄屋となった吉原家の住宅。住人は留守のようだ。土間から良い匂いがするぞ・・行ってみよう！</p>
        </div>

        <!-- クイズセクション -->
        <div class="quiz-section" id="quiz">
            <p class="question-text">住人「お、お前さんたち、何者だい！？」</p>
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:　怪しい者ではありません</button>
                <button class="option-button" data-value="2">2:　高橋さんの友人です</button>
            </div>
            <button class="submit-button" id="submitQuiz" disabled>解答する</button>
            <div class="feedback hidden" id="quizFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クイズの設定
            const quizConfig = {
                correctAnswer: '2',
                feedbackCorrect: {
                    text01: '住人「なあんだ、高橋さんの友人かい！ちょうど今、高橋さんに教えてもらったお酢ジュースを土間で作ってるところだ、お前らにもレシピをくれてやる」',
                    text02: '住人「高橋さんに伝えておいてくれ、俺らはあんたのお酢が大好きだって！小さいころから変わらない味だ、ずっとこのままで頼むよ！」',
                    image: '<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara02.png',
                    file: '<?php echo get_template_directory_uri(); ?>/assets/document/cocktail.pdf'
                },
                feedbackIncorrect: {
                    text: '住人「怪しい！勝手に家に入り込みやがって！けえれけえれ！」',
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
                    feedbackContent += `<a href="${feedback.file}" download>お酢ジュースのレシピを手に入れる</a>`;
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
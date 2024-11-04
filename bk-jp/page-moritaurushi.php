<?php get_header();?>

<body>
    <div class="quiz-container">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/monpe01.png" alt="イントロ画像" />
            <p>うるし屋店長「何の用だ！うちは創業1828年、家具の町大川では、仏壇、箪笥などの家具の塗料として漆は欠かせない存在だ、冷やかしなら出ていきな！」</p>
        </div>

        <!-- 選択式クイズセクション -->
        <div class="quiz-section" id="multipleChoiceQuiz">
            <!-- <p class="question-text">選択式の問題文をここに入力します。</p> -->
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:　素敵な漆ですね</button>
                <button class="option-button" data-value="2">2:　聞き込みさせてください</button>
            </div>
            <button class="submit-button" id="submitMultipleChoice" disabled>解答する</button>
            <div class="feedback hidden" id="multipleChoiceFeedback"></div>
        </div>

        <!-- 入力式クイズセクション -->
        <div class="quiz-section hidden" id="textInputQuiz">
            <input type="text" class="text-input" id="textAnswer" placeholder="うるし屋店長「ほう・・お前さん、漆が分かるってのかい？ならあんた、漆に混ぜ込むと強度があがる成分はなんだか言ってみな」">
            <button class="submit-button" id="submitTextInput">解答する</button>
            <div class="feedback hidden" id="textInputFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 選択式クイズの設定
            const multipleChoiceQuiz = {
                correctAnswer: '1',
                feedbackCorrect: {
                    text: '',
                },
                feedbackIncorrect: {
                    text: 'うるし屋店長「ふんっ・・！そんな見え透いたお世辞を言うやつは嫌いだね！」',
                }
            };

            // 入力式クイズの設定
            const textInputQuiz = {
                correctAnswer: 'プロテイン',
                feedbackCorrect: {
                    text: 'うるし屋のスタッフ「やるじゃねえか・・うるしってのは、建具や木工など、他の産業があって活きてくるもんだ。高橋さんちのお酢も一緒で、周囲の産業との調和があってはじめて成り立つもの、それをあそこの主人さんはよく知ってなさる。大量生産？そうしないほうがいいのは、彼が一番知ってるはずだぜ」',
                },
                feedbackIncorrect: {
                    text: 'うるし屋店長「違う違うっ！やっぱりあんたに漆は分からんめなぁ。ヒントはアレだよ、最近の若い子たちが、ジムに行ったあとに飲むあれだ・・」',
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
                
                // フィードバック内容を設定
                feedbackDiv.innerHTML = feedbackContent;
                feedbackDiv.className = `feedback ${isCorrect ? 'correct' : 'incorrect'}`;
            });
        });
    </script>
</body>
</html>
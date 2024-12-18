<?php get_header();?>
<body>
    <div class="quiz-container">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/monpe01.png" alt="イントロ画像" />
            <!-- <h1>クイズタイトル</h1> -->
            <p>もんぺ屋店長「おいおい、お店の前でじろじろしやがって！うちがもんぺ屋だと知ってのことか！？」</p>
        </div>

        <!-- 選択式クイズセクション -->
        <div class="quiz-section" id="multipleChoiceQuiz">
            <!-- <p class="question-text">選択式の問題文をここに入力します。</p> -->
            <div class="quiz-options">
                <button class="option-button" data-value="1">1:　知ってますよ</button>
                <button class="option-button" data-value="2">2:　もんぺ屋ってなんですか？</button>
            </div>
            <button class="submit-button" id="submitMultipleChoice" disabled>解答する</button>
            <div class="feedback hidden" id="multipleChoiceFeedback"></div>
        </div>

        <!-- 入力式クイズセクション -->
        <div class="quiz-section hidden" id="textInputQuiz">
            <input type="text" class="text-input" id="textAnswer" placeholder="もんぺ屋が作られたのは西暦何年？">
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
                    text: 'もんぺ屋店長「本当か？なら、おんぺが作られたのは西暦何年のことだ、言ってみろ」',
                },
                feedbackIncorrect: {
                    text: 'もんぺ屋店長「かぁー・・そんなことも知らねえのか！もんぺってのは戦時中の1942年に制定された「活動衣・作業着」だ。革命的な暖かさと動きやすさを持つことから、戦後も国民着として愛されてる、まさに和と洋の融合した日常着だ！」',
                }
            };

            // 入力式クイズの設定
            const textInputQuiz = {
                correctAnswer: '1942',
                feedbackCorrect: {
                    text: '「おっと失礼した、あんたら日本の歴史に詳しいんだなぁ・・なに、あんた達庄分酢さんのお友達だって？うちの家ね、庄分酢さんのお酢の煙で黒くなってるんだぜ」「でもな、そんなことで文句言う人この町にはいない。だって、昔から続いているものだもんな。もうそれが当たり前、日常の一つになっちゃってる、ってわけよ」',
                },
                feedbackIncorrect: {
                    text: 'もう一度考えてみましょう。',
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
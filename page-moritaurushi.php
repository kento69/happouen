<?php get_header();?>

<body>
    <div class="quiz-container -urushi">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/monpe01.png" alt="イントロ画像" />
            <p>Urushi shop owner: "Welcome! You must be new here. Our shop has been in business since 1828. Okawa is a furniture town, and our lacquer has been indispensable for things like Buddhist altars and dressers. We're very busy today and don't have time for browsers, so please leave!" </p>
        </div>

        <!-- 選択式クイズセクション -->
        <div class="quiz-section" id="multipleChoiceQuiz">
            <!-- <p class="question-text">選択式の問題文をここに入力します。</p> -->
            <div class="quiz-options">
                <button class="option-button" data-value="1">"This lacquer is very beautiful."</button>
                <button class="option-button" data-value="2">"Wait! Please let us stay. We know a little about lacquer."</button>
            </div>
            <button class="submit-button" id="submitMultipleChoice" disabled>Answer</button>
            <div class="feedback hidden" id="multipleChoiceFeedback"></div>
        </div>

        <!-- 入力式クイズセクション -->
        <div class="quiz-section hidden" id="textInputQuiz">
            <input type="text" class="text-input" id="textAnswer" placeholder="Input Password">
            <button class="submit-button" id="submitTextInput">Answer</button>
            <div class="feedback hidden" id="textInputFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 選択式クイズの設定
            const multipleChoiceQuiz = {
                correctAnswer: '2',
                feedbackCorrect: {
                    text: 'Urushi shop owner: "Hmph...you claim to understand lacquer, do you? Alright, tell me this: what is the component that, when mixed into lacquer, increases its strength?"',
                },
                feedbackIncorrect: {
                    text: '"Obviously it beautiful! I don\'t have time for empty compliments. Get out!"',
                }
            };

            // 入力式クイズの設定
            const textInputQuiz = {
                correctAnswer: 'protein',
                feedbackCorrect: {
                    text: 'Urushi shop owner: "Not bad...we use our lacquer to coat our woodwork. Without the wood to shine, our lacquer would be useless. You know Mr. Takahashi, right? His vinegar is like our lacquer, it can only exist in harmony with the surrounding industries. Take those away, and his vinegar would lose its flavor. He wishes to mass produce his vinegar?! He should know better than anyone what a terrible idea that would be!"',
                },
                feedbackIncorrect: {
                    text: 'Urushi shop owner: "Ha ha ha! You don\'t know anything about lacquer, do you? Here\'s a hint before you leave: it\'s that stuff young people drink after going to the gym!"',
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
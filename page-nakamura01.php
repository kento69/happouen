<?php get_header();?>

<body>
    <div class="quiz-container -paper">
        <!-- イントロセクション -->
        <div class="intro" id="quizIntro">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/monpe01.png" alt="イントロ画像" />
            <p>The Nakamura paper shop was first built in 1883. Before the war, it dealt in daily household goods, but since then, it has become a specialized paper shop still active to this day. Located in the heart of the town, it is highly approachable and visible to the public, which is why the official bulletin board was set up in front of it. </p>
            <p>Shopkeeper: "Hey, you there! Are you travelers? I could use a little help...could you please give me a hand?"</p>
            <p>It seems they're in trouble; let's go inside.</p>
        </div>

        <!-- 選択式クイズセクション -->
        <div class="quiz-section" id="multipleChoiceQuiz">
            <p class="question-text">Shopkeeper: "Thank you for your time. My eyesight's been getting worse lately and I seem to have misplaced my glasses. Could you help me find them in this pile of old tools?"</p>
            <div class="quiz-options">
                <button class="option-button" data-value="1">Yes</button>
                <button class="option-button" data-value="2">No</button>
            </div>
            <button class="submit-button" id="submitMultipleChoice" disabled>Answer</button>
            <div class="feedback hidden" id="multipleChoiceFeedback"></div>
        </div>

        <!-- 入力式クイズセクション -->
        <div class="quiz-section hidden" id="textInputQuiz">
            <p class="question-text">Did you find them? How many were there?</p>
            <input type="text" class="text-input" id="textAnswer" placeholder="Input Number">
            <button class="submit-button" id="submitTextInput">Answer</button>
            <div class="feedback hidden" id="textInputFeedback"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 選択式クイズの設定
            const multipleChoiceQuiz = {
                correctAnswer: '1',
                feedbackCorrect: {
                    text: 'Um, I\'ll try to find the glasses in the toolbox for you.',
                },
                feedbackIncorrect: {
                    text: 'Shopkeeper: "Young people have no manners these days!"',
                }
            };

            // 入力式クイズの設定
            const textInputQuiz = {
                correctAnswer: '2',
                feedbackCorrect: {
                    text: 'Shopkeeper: "Yes, yes, that\'s the one! Oh, thank you so much! I bought these Western-style glasses for me and the missus. Without them, we wouldn\'t be able to read the newspaper."',
                    text01: '"What was that about Takahashi? He\'s thinking of mass producing?...Well, I don\'t know all the details, but I\'ll support whatever he decides to do. I just hope it doesn\'t change the taste of the vinegar. It\'s delicious just the way it is. Hahaha!"',
                },
                feedbackIncorrect: {
                    text: 'Hmm, those aren\'t it.',
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

                // テキストが存在し、空でない場合のみ追加
                if (feedback.text01 && feedback.text01.trim() !== '') {
                    feedbackContent += `<p class="feedback-text">${feedback.text01}</p>`;
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
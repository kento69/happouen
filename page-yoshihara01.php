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
            padding: 16px 32px;
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
            padding: 10px 20px;
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
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hanzakai/yoshihara01.png" alt="イントロ画像" />
            <p>ここは柳川藩小保町の別当職を代々務め、のちに蒲池組の大庄屋となった吉原家の住宅。</p>
            <p>住人は留守のようだ。土間から良い匂いがするぞ・・</p>
            <p>行ってみよう！</p>
        </div>
</body>
</html>
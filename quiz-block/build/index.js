// src/index.js (ブロックエディタ用のJavaScript)
const { registerBlockType } = wp.blocks;
const { InspectorControls, RichText } = wp.blockEditor;
const { PanelBody, TextControl, Button } = wp.components;

// 選択式クイズブロックの登録
registerBlockType('my-quiz/multiple-choice', {
    title: '選択式クイズ',
    icon: 'format-quiz',
    category: 'common',
    attributes: {
        question: {
            type: 'string',
            default: ''
        },
        choices: {
            type: 'array',
            default: ['', '', '']
        },
        correctAnswer: {
            type: 'number',
            default: 0
        },
        correctMessage: {
            type: 'string',
            default: '正解です！'
        },
        incorrectMessage: {
            type: 'string',
            default: '不正解です。'
        },
        nextQuizId: {
            type: 'string',
            default: ''
        }
    },

    edit: function(props) {
        const { attributes, setAttributes } = props;
        
        return (
            <>
                <InspectorControls>
                    <PanelBody title="クイズ設定">
                        <TextControl
                            label="正解の選択肢番号（0から開始）"
                            value={attributes.correctAnswer}
                            onChange={(value) => setAttributes({ correctAnswer: parseInt(value) })}
                            type="number"
                        />
                        <TextControl
                            label="次のクイズID"
                            value={attributes.nextQuizId}
                            onChange={(value) => setAttributes({ nextQuizId: value })}
                        />
                        <RichText
                            label="正解時メッセージ"
                            value={attributes.correctMessage}
                            onChange={(content) => setAttributes({ correctMessage: content })}
                        />
                        <RichText
                            label="不正解時メッセージ"
                            value={attributes.incorrectMessage}
                            onChange={(content) => setAttributes({ incorrectMessage: content })}
                        />
                    </PanelBody>
                </InspectorControls>
                <div className="quiz-block-editor">
                    <RichText
                        tagName="p"
                        placeholder="質問を入力"
                        value={attributes.question}
                        onChange={(content) => setAttributes({ question: content })}
                    />
                    {attributes.choices.map((choice, index) => (
                        <TextControl
                            key={index}
                            placeholder={`選択肢 ${index + 1}`}
                            value={choice}
                            onChange={(value) => {
                                const newChoices = [...attributes.choices];
                                newChoices[index] = value;
                                setAttributes({ choices: newChoices });
                            }}
                        />
                    ))}
                </div>
            </>
        );
    },

    save: function() {
        return null; // PHP側でレンダリング
    }
});

// 入力式クイズブロックの登録
registerBlockType('my-quiz/text-input', {
    title: '入力式クイズ',
    icon: 'format-quiz',
    category: 'common',
    attributes: {
        question: {
            type: 'string',
            default: ''
        },
        correctAnswer: {
            type: 'string',
            default: ''
        },
        correctMessage: {
            type: 'string',
            default: '正解です！'
        },
        incorrectMessage: {
            type: 'string',
            default: '不正解です。'
        },
        nextQuizId: {
            type: 'string',
            default: ''
        }
    },

    edit: function(props) {
        const { attributes, setAttributes } = props;
        
        return (
            <>
                <InspectorControls>
                    <PanelBody title="クイズ設定">
                        <TextControl
                            label="正解"
                            value={attributes.correctAnswer}
                            onChange={(value) => setAttributes({ correctAnswer: value })}
                        />
                        <TextControl
                            label="次のクイズID"
                            value={attributes.nextQuizId}
                            onChange={(value) => setAttributes({ nextQuizId: value })}
                        />
                        <RichText
                            label="正解時メッセージ"
                            value={attributes.correctMessage}
                            onChange={(content) => setAttributes({ correctMessage: content })}
                        />
                        <RichText
                            label="不正解時メッセージ"
                            value={attributes.incorrectMessage}
                            onChange={(content) => setAttributes({ incorrectMessage: content })}
                        />
                    </PanelBody>
                </InspectorControls>
                <div className="quiz-block-editor">
                    <RichText
                        tagName="p"
                        placeholder="質問を入力"
                        value={attributes.question}
                        onChange={(content) => setAttributes({ question: content })}
                    />
                    <div className="quiz-input-preview">
                        <input type="text" placeholder="回答入力欄" disabled />
                        <button disabled>回答する</button>
                    </div>
                </div>
            </>
        );
    },

    save: function() {
        return null; // PHP側でレンダリング
    }
});

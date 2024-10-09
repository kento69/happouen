(()=>{"use strict";var r,o={597:()=>{const r=window.wp.blocks,o=window.wp.i18n,e=window.wp.blockEditor,i=window.ReactJSXRuntime,n=JSON.parse('{"UU":"quiz-block/quiz-block"}');(0,r.registerBlockType)(n.UU,{edit:function(){return(0,i.jsx)("p",{...(0,e.useBlockProps)(),children:(0,o.__)("Quiz-block – hello from the editor!","quiz-block")})}})}},e={};function i(r){var n=e[r];if(void 0!==n)return n.exports;var t=e[r]={exports:{}};return o[r](t,t.exports,i),t.exports}i.m=o,r=[],i.O=(o,e,n,t)=>{if(!e){var l=1/0;for(p=0;p<r.length;p++){e=r[p][0],n=r[p][1],t=r[p][2];for(var c=!0,s=0;s<e.length;s++)(!1&t||l>=t)&&Object.keys(i.O).every((r=>i.O[r](e[s])))?e.splice(s--,1):(c=!1,t<l&&(l=t));if(c){r.splice(p--,1);var u=n();void 0!==u&&(o=u)}}return o}t=t||0;for(var p=r.length;p>0&&r[p-1][2]>t;p--)r[p]=r[p-1];r[p]=[e,n,t]},i.o=(r,o)=>Object.prototype.hasOwnProperty.call(r,o),(()=>{var r={57:0,350:0};i.O.j=o=>0===r[o];var o=(o,e)=>{var n,t,l=e[0],c=e[1],s=e[2],u=0;if(l.some((o=>0!==r[o]))){for(n in c)i.o(c,n)&&(i.m[n]=c[n]);if(s)var p=s(i)}for(o&&o(e);u<l.length;u++)t=l[u],i.o(r,t)&&r[t]&&r[t][0](),r[t]=0;return i.O(p)},e=self.webpackChunkquiz_block=self.webpackChunkquiz_block||[];e.forEach(o.bind(null,0)),e.push=o.bind(null,e.push.bind(e))})();var n=i.O(void 0,[350],(()=>i(597)));n=i.O(n)})();

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

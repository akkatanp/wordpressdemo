<div id="adProduct-content">
  <iframe src="https://adproduct.timeinc.com" style="width: 100%; height:100%;" frameborder="0"></iframe>
</div>
<script>
  tinymce = parent.tinymce;
	editor = tinymce.activeEditor;
  var quizInfo = {
    url: '',
    id: ''
  };

  function defineListener() {
    if (window.addEventListener) {
      window.addEventListener("message", handleMessage, false);
      }
      else {
          window.attachEvent("onmessage", handleMessage);
      }
  };
  function handleMessage(evt) {
      if (evt.data.eventName === 'EMBED_QUIZ') {
          quizInfo.url = evt.data.quizDataUrl;
          quizInfo.id = evt.data.quizId;
          console.log('received data: %s', JSON.stringify(quizInfo));

          editor.insertContent('[adproduct qid="'+quizInfo.id+'" qsrc="'+quizInfo.url+'"]');

          tinymce.activeEditor.windowManager.close();

      }
  };
  defineListener();
</script>

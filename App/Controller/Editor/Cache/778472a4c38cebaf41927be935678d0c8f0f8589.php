<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8" />
        <title>Editor</title>
        <link rel="stylesheet" href="/App/Controller/Editor/View/examples/css/style.css" />
        <link rel="stylesheet" href="/App/Controller/Editor/View/css/editormd.css" />   
        <link rel="shortcut icon" href="https://pandao.github.io/editor.md/favicon.ico" type="image/x-icon" />
    </head>
    <body>
        <div id="layout">
            <div id="test-editormd"></div>
        </div>
        <script src="/App/Controller/Editor/View/examples/js/jquery.min.js"></script>
        <script src="/App/Controller/Editor/View/editormd.js"></script>
        <script src="/App/Controller/Editor/View/jquery.cookie.js"></script>
        <script type="text/javascript">
            var testEditor;
            $(function() {

                $.get("editor<?php echo e(isset($aid)&&$aid!=-1?'?aid='.$aid:''); ?>",function(md){
                    testEditor = editormd("test-editormd", {
                        width: "90%",
                        height: 740,
                        path : '/App/Controller/Editor/View/lib/',
                        theme : "dark",
                        previewTheme : "dark",
                        editorTheme : "pastel-on-dark",
                        markdown : md,
                        codeFold : true,
                        //syncScrolling : false,
                        saveHTMLToTextarea : true,    // 保存 HTML 到 Textarea
                        searchReplace : true,
                        //watch : false,                // 关闭实时预览
                        htmlDecode : "style,script,iframe|on*",            // 开启 HTML 标签解析，为了安全性，默认不开启
                        //toolbar  : false,             //关闭工具栏
                        //previewCodeHighlight : false, // 关闭预览 HTML 的代码块高亮，默认开启
                        emoji : true,
                        taskList : true,
                        tocm            : true,         // Using [TOCM]
                        tex : true,                   // 开启科学公式TeX语言支持，默认关闭
                        flowChart : true,             // 开启流程图支持，默认关闭
                        sequenceDiagram : true,       // 开启时序/序列图支持，默认关闭,
                        //dialogLockScreen : false,   // 设置弹出层对话框不锁屏，全局通用，默认为true
                        //dialogShowMask : false,     // 设置弹出层对话框显示透明遮罩层，全局通用，默认为true
                        //dialogDraggable : false,    // 设置弹出层对话框不可拖动，全局通用，默认为true
                        //dialogMaskOpacity : 0.4,    // 设置透明遮罩层的透明度，全局通用，默认值为0.1
                        //dialogMaskBgColor : "#000", // 设置透明遮罩层的背景颜色，全局通用，默认为#fff
                        imageUpload : true,
                        imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                        imageUploadURL : "./php/upload.php",
                        onload : function() {
                            console.log('onload', this);
                            this.fullscreen();
                            alert("ctrl+s 保存 \nctrl+alt+q 退出 \n更换标题就可以新建文章！")
                        }
                    });
                });
                

                document.onkeydown = function(e){
                    var ev = document.all ? window.event : e;
                    var token=$.cookie('token');
                    if(ev.ctrlKey  &&  window.event.keyCode==83 ){ 
                        document.mk_title=testEditor.getMarkdown().split(/[\n,]/g)[0].slice(2);
                        console.log(document.mk_title);
                        $.ajax({
                            type:"post",
                            url:"http://api-lerko.ngrok.cc/article/addArticle",
                            data:{
                                "id":<?php echo e($aid); ?>,
                                "title":document.mk_title,
                                "content":testEditor.getHTML(),
                                "markdown":testEditor.getMarkdown()
                            },
                            headers : {'authorization':token},
                            success:function(data){
                                if(!data.status){
                                    alert(data.msg);
                                }
                                document.save_id=data.id;
                            },
                            error:function(data){
                                alert("保存失败");
                            }
                        });
                        return false;
                    }
                    else if(ev.ctrlKey && ev.altKey  &&  window.event.keyCode==81 ){
                        window.location.href="http://view-lerko.ngrok.cc";
                    }
                }
            });
        </script>
    </body>
</html>
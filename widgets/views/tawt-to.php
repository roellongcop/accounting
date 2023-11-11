<?php

$this->registerJs(<<< JS
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    Tawk_API.visitor = {
        name: '{$user->username}',
        email: '{$user->email}',
    };
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/654f1d49cec6a912820ed232/1heugkqlg';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
JS)
?>
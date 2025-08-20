<footer class="max-w-screen-xl mx-auto flex items-center justify-between py-10 border-t border-t-gray-300">
    <div>
        <?php
        if (function_exists("the_custom_logo")) {
            add_filter('get_custom_logo', 'add_logo_classes');
            the_custom_logo();
        }
        ?>
    </div>
    <div class="text-sm">©کلیه حقوق این سایت برای پارت محفوظ می‌باشد.</div>
    <div class="flex gap-2">
        <a href=""><i class="border border-gray-500 rounded-full w-8 h-8 flex justify-center items-center ri-twitter-fill"></i></a>
        <a href=""><i class="border border-gray-500 rounded-full w-8 h-8 flex justify-center items-center ri-linkedin-fill"></i></a>
        <a href=""><i class="border border-gray-500 rounded-full w-8 h-8 flex justify-center items-center ri-facebook-fill"></i></a>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
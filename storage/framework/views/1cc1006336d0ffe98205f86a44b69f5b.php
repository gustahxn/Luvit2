<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $__env->yieldContent('title', 'Luvit'); ?></title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="icon" href="<?php echo e(asset('images/icones.png')); ?>" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"/>
  <style>
    :root { --rose: #f43f5e; --ink:#0b0b0f; }
    body{ background: radial-gradient(1200px 600px at 10% -10%, rgba(244,63,94,.15), transparent),
                       radial-gradient(900px 500px at 90% -20%, rgba(59,130,246,.1), transparent),
                       #0c0d10; color: #eaeaec; font-family: 'Inter',system-ui,-apple-system,Segoe UI,Roboto; }
    .glass{ backdrop-filter: blur(10px); background: linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.03)); border: 1px solid rgba(255,255,255,.12); }
    html, body { height: 100%; overflow: hidden; }
  </style>
</head>
<body>
  <main><?php echo $__env->yieldContent('content'); ?></main>
  <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH /home/gustahxn/Stuff/coding/Luvit/resources/views/layouts/auth.blade.php ENDPATH**/ ?>
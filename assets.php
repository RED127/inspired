<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $APP_TITLE;?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
  tailwind.config = {
    corePlugins: {
      preflight: false,
    },
    // prefix: "tw-"
  }
  </script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <style>
  *,
  ::before,
  ::after {
    border-width: 0;
    border-style: solid;
    border-color: theme('borderColor.DEFAULT', currentColor);
  }

  body {
    font-family: Arial, Helvetica, sans-serif;
  }

  .navbar {
    position: relative;
  }

  .content{
    padding-top:5% !important;
  }

  .brand {
    position: absolute;
    left: 50%;
    margin-left: -50px !important;
    /* 50% of your logo width */
    display: block;
  }

  #loading {
    position: fixed;
    top: 0;
    z-index: 100;
    width: 100%;
    height: 100%;
    display: none;
    background: rgba(0, 0, 0, 0.6);
  }

  .cv-spinner {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .spinner {
    width: 40px;
    height: 40px;
    border: 4px #ddd solid;
    border-top: 4px #2e93e6 solid;
    border-radius: 50%;
    animation: sp-anime 0.8s infinite linear;
  }

  @keyframes sp-anime {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(359deg);
    }
  }

  .is-hide {
    display: none;
  }
  </style>
</head>
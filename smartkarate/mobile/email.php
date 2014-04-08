<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
    <!--<![endif]-->
    <head>

        <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,700' rel='stylesheet' type='text/css'>

        <link rel="icon" type="image/x-icon" href="favicon.ico" />

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Locations</title>

        <meta name="keyword" content="" />
        <meta name="description" content="" />

        <meta name="viewport" content="width=device-width" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/validate.min.js"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css" />

        <!-- UNCOMMENT GOOGLE ANALYTICS CODE -->
        <!--<script type="text/javascript">
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-XXXXXX-X']);
                _gaq.push(['_trackPageview']);
                (function () {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();
        </script>-->

    </head>
    <body>
        <div class="wrapper">
            <div class="logo-container">
                <a href="index.html" class="logo logo-s"></a>

                <a href="index.html" class="page-nav prev"></a>
                <a href="about.html" class="page-nav next"></a>
            </div>

            <div role="main" class="page-content">
                <h1>Email</h1>
                <div class="success_box"><?php require_once 'send-email.php'; ?></div>
                <div class="error_box"></div>
                
                <form class="form" name="email_form" action="" method="post">
                    <div class="field">
                        <label>Name *</label>
                        <input type="text" name="name" value="" />
                    </div>
                    <div class="field">
                        <label>Email *</label>
                        <input type="text" name="email" value="" />
                    </div>
                    <div class="field">
                        <label>Phone (optional)</label>
                        <input type="text" name="phone" value="" />
                    </div>
                    <div class="field">
                        <label>Message *</label>
                        <textarea name="message" cols="20" rows="5"></textarea>
                    </div>
                    <div class="field">
                        <input type="submit" value="Submit" class="email-submit"/>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            var validator = new FormValidator('email_form', [{
                    name: 'name',
                    display: 'Name',
                    rules: 'required'
                }, {
                    name: 'email',
                    display: 'Email',
                    rules: 'required|valid_email'
                },{
                    name: 'message',
                    display: 'Message',
                    rules: 'required'
                }], function(errors, event) {
                if (errors.length > 0) {
                    var SELECTOR_ERRORS = $('.error_box'),
                            SELECTOR_SUCCESS = $('.success_box');

                    if (errors.length > 0) {
                        SELECTOR_ERRORS.empty();

                        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
                            SELECTOR_ERRORS.append(errors[i].message + '<br />');
                        }

                        SELECTOR_SUCCESS.css({display: 'none'});
                        SELECTOR_ERRORS.fadeIn(200);
                        
                         event.returnValue = false;
                    }

                }
            });
        </script>
    </body>
</html>

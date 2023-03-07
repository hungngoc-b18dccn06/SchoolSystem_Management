<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">

    <style>

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            position: relative;
            font-size: 16px;
            line-height: 1.5em;
            margin-top: 0;
            text-align: left;
            box-sizing: border-box;
        }


        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

    </style>
</head>
<body
    style=" position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
       style=" position: relative;  background-color: #edf2f7; margin: 0; padding: 0; width: 100%;">
    <tbody>
    <tr>
        <td align="center"
            style=" position: relative;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation"
                   style=" position: relative;  margin: 0; padding: 0; width: 100%;">
                <tbody>
                <tr>
                    <td class="header"
                        style=" position: relative; padding: 25px 0; text-align: center; background: #f6f6f6;">
                    </td>
                </tr>
                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0"
                        style="position: relative;margin: 0;padding: 0;background: #f6f6f6;border-bottom: none;border-top: none;width: 600px;">
                        <table class="inner-body" align="center" width="670" cellpadding="0" cellspacing="0"
                               role="presentation"
                               style=" position: relative; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 670px;">
                            <!-- Body content -->
                            <tbody>
                            <tr>
                                <td class="content-cell"
                                    style=" position: relative; max-width: 100vw; padding: 52px;">
                                    @yield('content')
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style=" position: relative; background: #f6f6f6;">
                        <table class="footer" align="center" width="600" cellpadding="0" cellspacing="0"
                               role="presentation"
                               style=" position: relative; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                            <tbody>
                            <tr>
                                <td class="content-cell" align="center"
                                    style=" position: relative; max-width: 100vw; padding: 32px;">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>

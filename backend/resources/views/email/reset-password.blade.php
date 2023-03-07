@extends('email.base')
@section('content')
    <p>このメールは、パスワード再設定手続きを行われた方へ送信しています。</p>
    <p>新しいパスワードを設定する方は、<br> 下記の「パスワード再設定」ボタンをクリックしてお進みください。</p>
    <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0"
           role="presentation"
           style="position: relative; margin: 30px auto; padding: 0; text-align: center; width: 100%; margin-bottom: 60px;">
        <tbody>
        <tr>
            <td align="center"
                style="position: relative;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                       role="presentation"
                       style="position: relative;">
                    <tbody>
                    <tr>
                        <td align="center"
                            style="position: relative;">
                            <table border="0" cellpadding="0" cellspacing="0"
                                   role="presentation"
                                   style="position: relative;">
                                <tbody>
                                <tr>
                                    <td style="position: relative;">
                                        <a target="_blank" rel="noopener noreferrer"
                                           href="{{$url}}"
                                           class="button button-primary"
                                           style="position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">パスワードを再設定</a>
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
    <p>内容に心当たりの無い方は、他の方が誤って手続きをしたものと思われます。<br> お手数ではございますが、このままメールを削除してください。</p>
@endsection

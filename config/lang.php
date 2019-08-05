<?php

return [

    'lang' => [

        'mail' => [

            'activation' => [
                'subject' => env('APP_NAME', 'My App') . ' Ativação da conta',
            ],

            'password' => [
                'forgot' => [
                    'subject' => env('APP_NAME', 'My App') . ' Requisição de renovação da senha',
                ],
            ],

        ],

        'alerts' => [

            'error' => 'Ocorreu um erro no site. Desculpe pelo transtorno temporário.',
            'error_debug' => 'O aplicativo não pôde ser executado devido ao seguinte erro:',

            'requires_auth' => 'Você deve fazer login para acessar essa página.',
            'recaptcha_failed' => 'Verifique se você não é um robô completando o reCAPTCHA.',
            'forgot_password_success' => 'Se o seu e-mail for válido, você receberá um e-mail com instruções sobre como redefinir sua senha.',
            'forgot_password_failed' => 'Por favor insira o endereço de email associado à sua conta.',
            'reset_password_invalid' => 'Seu token de redefinição de senha é inválido. Envie outro pedido de redefinição da senha.',
            'reset_password_failed' => 'Sua senha não pôde ser redefinida neste momento.',
            'reset_password_success' => 'Você redefiniu sua senha com êxito. Agora você pode fazer login com a nova senha.',
            'reset_password_no_email' => 'Verifique seu e-mail.',

            'registration' => [
                'successful' => 'Sua conta foi criada!',
                'error' => 'Corrija os erros do registro e tente novamente.',
                'requires_mail_activation' => 'Sua conta foi criada, mas você precisará ativá-la. Verifique seu e-mail para obter instruções.',
            ],

            'login' => [
                'invalid' => 'As informações de login não foram encontradas.',
                'error' => 'As informações de login não foram encontradas.',
                'resend_activation' => 'Um email de ativação foi enviado. Verifique seu e-mail para obter instruções.',
                'activate' => 'A conta que você está tentando acessar não foi ativada.',
            ],

            'account' => [
                'already_activated' => 'Sua conta já foi ativada.',
                'activatied' => 'Sua conta foi ativada! Agora você pode ter acesso.',
                'invalid_active_hash' => 'A chave que você está tentando usar já expirou ou nunca existiu.',

                'password' => [
                    'updated' => 'Sua senha foi alterada.',
                    'failed' => 'Sua senha não pôde ser alterada no momento.',
                ],

                'profile' => [
                    'updated' => 'Seu e-mail foi atualizado!',
                    'failed' => 'Seu perfil não pôde ser atualizado no momento.',
                ],
            ],

        ],

    ],

];

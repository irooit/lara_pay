<?php
// 用户相关配置
return [
    //允许注册
    'enableRegistration' => true,

    //通过社交账户登录的用户，在没有绑定账户的情况下是否自动注册用户？
    'enableSocialiteAutoRegistration' => true,

    //通过短信验证码登录是否，在用户不存在的情况下是否自动注册用户？
    'enableSmsAutoRegistration' => true,

    //允许密码找回
    'enablePasswordRecovery' => false,

    //启用注册欢迎邮件
    'enableWelcomeEmail' => false,

    //头像存储磁盘
    'avatarDisk' => 'local',

    //实名认证证件照片存储磁盘
    'identificationDisk' => 'local',

];
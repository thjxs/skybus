# SkyBus

## Model && Migrations && Policies
* Comment
* Content
* Node
* Notification
* Profile
* Report
* Thread

## Notifications
* CommentMyThread
* LikedMyThread
* MentionMe
* NewFollower
* NewPrivateMessage
* SubscribeMyThread
* Welcome

## Mail
VerifyEmail

## Packages
* laravel/passport
* laravel/socialite
* predis/predis

## Register
* validate request

* create user

  ### New Registered Event

  Send verify email

* response with token

  ### Resend Verify email

  * if has verified email return ; else resend verify email


## Passport
* boot Passport:route 
* password client | client_id, client_secret, grant_type


### Configuration
* Passport::tokenExpireIn(now()->addDays(30));
* Passport::refreshTokensExpireIn(now()->addDays(30));

## VerifyEmail
* hasValiadSignature()
* markEmailAsVerified()
* redirect()

## Reset Email

## User Activity
* Redis Bitmap BITCOUNT
* BITOP AND dest key1 key2 ...

## 计划

1. 文件上传
2. Node
3. Thread
4. Content
5. Activity Log

## Activity log
subject_type | causer 

## filter

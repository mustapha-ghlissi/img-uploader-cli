# img-uploader-cli
### Installation guide

#### 1) Technical requirements:
  Make sure you have **symfony cli**, **php >= 7.2** and **composer** installed in your machine. 

#### 2) Install dependencies
  ```
  composer install
  ```
  
#### 3) Starting the server 
  ```
  symfony server:start
  ```
  
#### 4) Upload an image
  ```
  php bin/console app:upload-img
  ```
  
  You will be asked to enter the image local absolute path (Exp: /home/mustapha/Desktop/banner.png) then hit enter.
  Now just check the folder ***public/uploads/images*** and you have to see the image there.
  
#### 5) Remove an image
  ```
  php bin/console app:remove-img
  ```
  
  You will be asked to enter the image name to be removed from the folder ***public/uploads/images*** then hit enter to delete the image.
  
#### 6) That's all !

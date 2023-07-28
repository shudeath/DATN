import cv2
import numpy as np

img = cv2.imread('Image/Elon_Musk_1.jpg')
print(img.shape)

imgResize = cv2.resize(img, (480, 640))
imgCropped = img[0:200,200:500]

cv2.imshow('img', img)
cv2.imshow('imgResize', imgResize)
cv2.imshow('imgCropped', imgCropped)

cv2.waitKey(0)

cv2.destroyAllWindows()
import cv2
import numpy as np

#print(cv2.__version__)

img = cv2.imread('PersonList/Elon Musk/Elon_Musk_1.jpg',1)
kernel = np.ones((5, 5), np.uint8)

imgCanny = cv2.Canny(img, 150, 200)
imgDialation = cv2.dilate(imgCanny, kernel, iterations = 1)
imgEroded = cv2.erode(imgDialation, kernel, iterations = 1)

cv2.imshow('imageCanny', imgCanny)
cv2.imshow('imgDialation', imgDialation)
cv2.imshow('imgEroded', imgEroded)

cv2.waitKey(0)

cv2.destroyAllWindows()
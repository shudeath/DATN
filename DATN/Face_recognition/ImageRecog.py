import numpy as np
import cv2
import time
from FaceDetectionModule import FaceDetector
import pickle
import os

labels = {}
with open('label.pickle', 'rb') as f:
    og_labels = pickle.load(f)
    labels = {v:k for k,v in og_labels.items()}

repeat = np.zeros(len(labels))

imgList = os.listdir('TestImage')
print(imgList)
recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read('TrainedModel.yml')

detector = FaceDetector(minDetectionCon=0.4)
face_cascade = cv2.CascadeClassifier('Cascade/haarcascade_frontalface_default.xml')
#meshDetector = FaceMeshDetector(maxFaces=20, minDetectionCon=0.5, minTrackCon=0.5)

cap = cv2.VideoCapture(0)
#cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1600)
#cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 960)

def cascade_detector(imgName, frame):
    name = ""
    color = (0,255,0)
    stroke = 1
    font = cv2.FONT_HERSHEY_DUPLEX
    gray=cv2.cvtColor(frame,cv2.COLOR_BGR2GRAY)
    faces=face_cascade.detectMultiScale(gray)
    
    for(x,y,w,h) in faces:
        cv2.rectangle(frame,(x,y),(x+w,y+h),(0, 255, 0), 2)
        roi_gray = gray[y:y+h, x:x+w]
        roi_gray = cv2.resize(roi_gray, (256,256), interpolation=cv2.INTER_AREA)
        id, confidence = recognizer.predict(roi_gray)
        if confidence <90:
            name = labels[id]
        else:
            name = "Unknown"
        print(imgName, " is ",name, " ",confidence, "%")
        name = labels[id] + ' - ' + str(round(confidence)) +'%'
        cv2.putText(frame, name, (x,y-10), font, 0.7, color, stroke, cv2.LINE_AA)


def main():    
    percent = 40
    size = (256, 256)
    name = ''
    for imgName in imgList:
        img = cv2.imread(f'TestImage/{imgName}')
        #print(repeat)
        #imgRGB = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        grayImg = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        #print("Cascade detector:")
        cascade_detector(imgName, img)
        continue
        #print("Mediapipe detector:")
        bboxs = detector.findFaces(img, draw=False, Text=False)

        if len(bboxs) > 0:
            for i in range(len(bboxs)): 
                x, y, w, h = bboxs[i][1]
                if x<0: x=0
                if y<0: y=0
                face = grayImg[y:y+h, x:x+w]
                face = cv2.resize(face, size, interpolation=cv2.INTER_AREA)
                cv2.imshow("Image",face)
                id_, conf = recognizer.predict(face)
                if conf >=percent:             
                    name = labels[id_]# + ' - ' + str(round(conf)) +'%'
                else:
                    name = "Unknown"
                print(imgName, " is ",name)
    #use camera
    '''while True:
        success, img = cap.read()
        grayImg = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        cascade_detector('Name', img)
        cv2.imshow("Image", img)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break'''

if __name__ == "__main__":
   	main()
cv2.destroyAllWindows()
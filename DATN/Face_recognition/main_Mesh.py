from cProfile import label
from csv import reader
import numpy as np
import cv2
#import matplotlib.pyplot as plt
import mediapipe as mp
import time
#import tensorflow as tf
from FaceMeshModule import FaceMeshDetector
import pickle
import requests
from threading import Thread
import threading
import screeninfo
from datetime import datetime
from multiprocessing import Process
import queue
import os
#import imutils

module_id = '000001'
module_password = '123456'
has_request = False
stop_ = False
labels = {}
ids = {}
message=''
fps = 0
rqTime = 0
Que = queue.Queue()
with open('label.pickle', 'rb') as f:
    og_labels = pickle.load(f)
    labels = {v:k for k,v in og_labels.items()}
    og_labels = pickle.load(f)
    ids = {v:k for k,v in og_labels.items()}
repeat = np.zeros(len(labels))

screen_id = 0
screen = screeninfo.get_monitors()[screen_id]
width, height = screen.width, screen.height

recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read('TrainedModel.yml')

def request():
    global stop_
    global has_request
    global message
    global Que
    global fps
    global rqTime
    print("Reaquest Start!")
    while stop_ == False:
        #print(repeat)
        cTime = time.time()
        if cTime - rqTime > 3: 
            message = ''
        if has_request == True:
            has_request = False
            while not Que.empty():
                i = Que.get()
                name = labels[i]
                now = datetime.now()
                print(name, now.strftime("%d/%m/%Y %H:%M:%S"))
                url = 'https://quanlynhansuhaui.000webhostapp.com/php/diemdanh.php'
                _ID = {'id': ids[i]}
                #print(url)
                rq = requests.post(url, data=_ID)
                #print(name, ": ",x.text)
                message = name + ': ' +rq.text
                rqTime = time.time()
def main():    
    pTime = 0
    rstTime = 0
    percent = 40
    im=0
    size = (128, 128)
    global repeat
    global stop_
    global has_request
    global message
    global fps
    global rqTime
    global Que
    color = (0,255,0)
    stroke = 1
    font = cv2.FONT_HERSHEY_DUPLEX

    cap = cv2.VideoCapture(0)
    cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1280)
    cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 720)
    detector = FaceMeshDetector(maxFaces=2,minDetectionCon=0.5)

    while True:
        success, img = cap.read()
        img, faces, boxs = detector.getFaces(img)

        if len(boxs) > 0:
            for i in range(len(boxs)):
                _face = cv2.resize(faces[i], (256,256), interpolation=cv2.INTER_AREA)
                if cv2.waitKey(1) & 0xFF == ord(' '):   
                    cv2.imwrite(os.path.join('TrainedList' , f'New_{im}.jpg'), _face)
                    im = im + 1
                x = boxs[i][0]
                y = boxs[i][1]
                id_, conf = recognizer.predict(_face)
                if conf >=percent:
                    repeat[id_] = repeat[id_] + 1                 
                    name = labels[id_] + ' - ' + str(round(conf)) +'%'
                    cv2.putText(img, name, (x,y-10), font, 0.7, color, stroke, cv2.LINE_AA)
                    if repeat[id_] >= fps:
                        Que.put_nowait(id_)
                        has_request = True
                        repeat[id_] = 0               
                else:
                    name = 'Unknown'
                    cv2.putText(img, name, (x,y-10), font, 0.7, color, stroke, cv2.LINE_AA)
                      

        cTime = time.time()
        if cTime - rstTime > 1:
            repeat = np.zeros(len(labels))
            rstTime = cTime
        fps = 1 / (cTime - pTime)
        pTime = cTime
        cv2.putText(img, f'fps: {int(fps)}', (820, 30), font, 1, color, 1)
        cv2.putText(img, message, (100, 40), font, 1, color, 1)
        '''cv2.namedWindow("Camera", cv2.WND_PROP_FULLSCREEN)  
        cv2.moveWindow("Camera", screen.x - 1, screen.y - 1)       
        cv2.setWindowProperty("Camera", cv2.WND_PROP_FULLSCREEN, cv2.WINDOW_FULLSCREEN)'''
        cv2.imshow("Camera", img)
        
        if cv2.waitKey(1) & 0xFF == ord('q'):     
            break
    stop_ = True
    cv2.destroyAllWindows()

'''p2 = Process(target=request)
p1 = Process(target=main)'''
th1 = threading.Thread(target=main)
th2 = threading.Thread(target=request)

if __name__ == "__main__":
    #main()
    th1.start()
    th2.start()
    th1.join()
    th2.join()
    '''p1.start() 
    p2.start()
    print("All process started!")
    p1.join()
    p2.join()'''

'''
try:
    t = time.time()    
    th1.start()
    th2.start()
    th1.join()
    th2.join()
    print('All Thread Started')
except:
    print('Error')'''
    
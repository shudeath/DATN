from matplotlib.pyplot import gray
from pyparsing import empty
from FaceMeshModule import FaceMeshDetector
import numpy as np
import cv2
import os, shutil
import pickle

detector = FaceMeshDetector(maxFaces=2,minDetectionCon=0.3)

class Persons():
    def __init__(self, folderNames):
        self.faces = []
        self.folderNames = folderNames
        self.imgNums = 0
        self.imgList = os.listdir(f'{path}/{self.folderNames}')
        self.ID = self.folderNames[:6]
        self.labels = self.folderNames[7:]
        for imgName in self.imgList:
            
            curImg = cv2.imread(f'{path}/{self.folderNames}/{imgName}', cv2.IMREAD_GRAYSCALE)
            #grayImg = cv2.cvtColor(curImg, gray,cv2.COLOR_BGR2GRAY)
            img_array = np.array(curImg, "uint8")
            size = (256, 256)
            face_array = cv2.resize (img_array, size, interpolation=cv2.INTER_AREA)
            self.faces.append(face_array)
            self.imgNums += 1
            '''except:
                print ("Get image error: ", imgName)'''
            #curImg, faces, boxs = detector.getFaces(curImg)
            '''if len(faces) > 0:
                self.imgNums += 1
                size = (256, 256)
                faces[0] = cv2.resize(faces[0], size, interpolation=cv2.INTER_AREA)
                self.faces.append(faces[0])
                cv2.imwrite(os.path.join('TrainedList' , f'{imgName}'), faces[0])'''
            #Get faces
            
            '''face,z = cascade_detector(curImg,size)
            if z==True:
                self.faces.append(face)
                cv2.imwrite(os.path.join('TrainedList' , f'{imgName}'), face)'''
            

            '''bboxs = detector.findFaces(curImg)
            if len(bboxs) < 1:
                pass
            else:
                x, y, w, h = bboxs[0][1]
                if x<0: x=0
                if y<0: y=0
                #print(imgName, x, y, w, h)
                grayImg = cv2.cvtColor(curImg, cv2.COLOR_BGR2GRAY)
                img_array = np.array(grayImg, "uint8")
                face_array = img_array[y:y+h, x:x+w]
                size = (128, 128)
                face_array = cv2.resize(face_array, size, interpolation=cv2.INTER_AREA)
                self.faces.append(face_array)
                #cv2.imshow("Face", face_array)
                #cv2.waitKey(0)'''

def cascade_detector(frame,size):
    global face_cascade
    gray=cv2.cvtColor(frame,cv2.COLOR_BGR2GRAY)
    faces=face_cascade.detectMultiScale(gray)
    img_array = np.array(gray, "uint8")
    #print (faces[0])
    for (x,y,w,h) in faces:
        if x<0: x=0
        if y<0: y=0
        roi_gray = img_array[y:y+h, x:x+w]
        roi_gray = cv2.resize(roi_gray, size, interpolation=cv2.INTER_AREA)
        return roi_gray,True
    return None ,False

face_recognizer = cv2.face.LBPHFaceRecognizer_create()
face_cascade = cv2.CascadeClassifier('Cascade/haarcascade_frontalface_default.xml')

path = 'PersonList'
myList = os.listdir(path)
#print(myList)
people = []
current_id = 0
label_ids = {}
ids_list = {}
y_labels = []
x_train = []
print("Collecting data...")
for name in myList:
    people.append(Persons(name))
for person in people:
    #print(people[i].img)
    #cv2.imshow("Image", person.faces[0])
    #cv2.waitKey(0)
    print (person.labels, ": " ,person.imgNums)
    label_ids[person.labels] = current_id
    ids_list[person.ID] = current_id
    current_id += 1
    for img in person.faces:
        x_train.append(img)
        y_labels.append(label_ids[person.labels])

with open("label.pickle", 'wb') as f:
    pickle.dump(label_ids, f)
    pickle.dump(ids_list, f)
print (label_ids)
print (ids_list)
print('Data create complete!')
print('Training...')
face_recognizer.train(x_train, np.array(y_labels))
face_recognizer.save('TrainedModel.yml')

print('Training complete!')

'''
cap = cv2.VideoCapture(0)
while True:
    success, frame = cap.read()
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    faces = face_cascade.detectMultiScale(gray, scaleFactor=1.5, minNeighbors=5)
    for (x, y, w, h) in faces:
        roi_gray = gray[y:y+h, x:x+w]
        roi_color = frame[y:y+h, x:x+w]

        color = (255, 0, 0)
        stroke = 2
        end_cord_x = x + w
        end_cord_y = y + h
        cv2.rectangle(frame, (x, y), (end_cord_x, end_cord_y), color, stroke)

    cv2.imshow("Result", frame)
    if cv2.waitKey(1) & 0xFF ==ord('q'):
     break'''
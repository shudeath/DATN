import cv2
import mediapipe as mp
import time

from numpy import unsignedinteger

class FaceMeshDetector():
    def __init__(self, staticMode=False, maxFaces=2, minDetectionCon=0.5, minTrackCon=0.5):
        self.staticMode = staticMode
        self.maxFaces = maxFaces
        self.minDetectionCon = minDetectionCon
        self.minTrackCon = minTrackCon

        self.mpDraw = mp.solutions.drawing_utils
        self.mpFaceMesh = mp.solutions.face_mesh
        self.faceMesh = self.mpFaceMesh.FaceMesh(self.staticMode, self.maxFaces,
                                                 min_detection_confidence= self.minDetectionCon,
                                                 min_tracking_confidence= self.minTrackCon)
        self.drawSpec = self.mpDraw.DrawingSpec(thickness=1, circle_radius=2)

    def findFaceMesh(self, img, draw=True, box = True):
        self.imgRGB = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        self.results = self.faceMesh.process(self.imgRGB)
        faces = []
        if self.results.multi_face_landmarks:
            for faceLms in self.results.multi_face_landmarks:
                if draw:
                    self.mpDraw.draw_landmarks(img, faceLms, self.mpFaceMesh.FACEMESH_CONTOURS,
                                               self.drawSpec, self.drawSpec)
                face = []
                for id, lm in enumerate(faceLms.landmark):
                    # print(lm)
                    ih, iw, ic = img.shape
                    x, y = int(lm.x * iw), int(lm.y * ih)
                    #cv2.putText(img, str(id), (x, y), cv2.FONT_HERSHEY_PLAIN,
                    # 0.7, (0, 255, 0), 1)
                    
                    #print(id,x,y)
                    face.append([x, y])
                faces.append(face)
        return img, faces
    def getFaces(self, img, draw=True, minwidth = 60):
        self.imgRGB = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        self.results = self.faceMesh.process(self.imgRGB)
        faces = []
        box = []
        if self.results.multi_face_landmarks:
            for faceLms in self.results.multi_face_landmarks:
                face = []
                for id, lm in enumerate(faceLms.landmark):
                    ih, iw, ic = img.shape
                    x, y = int(lm.x * iw), int(lm.y * ih)
                    face.append([x, y])
                x = face[234][0]
                y = int ((face[10][1] +  face[9][1]) / 2)
                if x<0: x=0
                if y<0: y=0
                w = face[454][0] - x
                h = face[152][1] - y
                if w/h > 2 or h/w > 2:
                    continue
                if w < minwidth or h < minwidth:
                    continue
                if draw:
                    bbox = x, y, w, h
                    cv2.rectangle(img, bbox, (0, 255, 0), 2)
                faces.append( gray[ y:y + h, x:x + h ] )
                box.append([x,y])
        return img, faces, box
'''
def maintest():
    cap = cv2.VideoCapture(0)
    cap.set(cv2.CAP_PROP_FRAME_WIDTH, 1280)
    cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 720)

    #mpDraw = mp.solutions.drawing_utils
    #mpFaceMesh = mp.solutions.face_mesh
    #faceMesh = mpFaceMesh.FaceMesh(max_num_faces=20)
    #drawSpec = mpDraw.DrawingSpec(thickness=1, circle_radius=2)

    cTime  = time.time()
    pTime = 0
    detector = FaceMeshDetector(maxFaces=2,minDetectionCon=0.3)
    while True:
        success, img = cap.read()
        img, faces = detector.getFaces(img)
        if len(faces)!= 0:
            1
        cTime = time.time()
        fps = 1 / (cTime - pTime)
        pTime = cTime
        cv2.putText(img, f'FPS: {int(fps)}', (20, 70), cv2.FONT_HERSHEY_PLAIN, 3, (0, 255, 0), 3)
        cv2.imshow('Image', img)
        if cv2.waitKey(1) & 0xFF == ord('q'):
            break
'''
#if __name__ == '__main_':
#main()
import cv2
import mediapipe as mp
import numpy as np

class FaceDetector():
    def __init__(self, minDetectionCon = 0.5):
        self.minDetectionCon = minDetectionCon
        self.mpFaceDetection = mp.solutions.face_detection
        self.mpDraw = mp.solutions.drawing_utils
        self.faceDetection = self.mpFaceDetection.FaceDetection(minDetectionCon)
    def findFaces(self, img, draw = True, Text = True):
        imgRGB = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        self.result = self.faceDetection.process(imgRGB)
        bboxs = []
        if self.result.detections:
            for id, detection in enumerate(self.result.detections):
                bboxC = detection.location_data.relative_bounding_box
                ih, iw, ic = img.shape
                bbox = int(bboxC.xmin * iw), int(bboxC.ymin * ih), \
                       int(bboxC.width * iw), int(bboxC.height * ih)
                bboxs.append([id, bbox, detection.score])
                if draw == True:
                    #self.fancyDraw(img, bbox)
                    cv2.rectangle(img, bbox, (0, 255, 0), 2)
                if Text == True:
                    cv2.putText(img, f'{int(detection.score[0] * 100)}%',
                    (bbox[0], bbox[1] - 20), cv2.FONT_HERSHEY_PLAIN,
                    2, (255, 0, 255), 2)
        return bboxs
    def fancyDraw(self, img, bbox, l=30, th=1):
        x, y, w, h = bbox
        x1, y1 = x + w, y + h

        #cv2.rectangle(img, bbox, (255, 0, 255), 2)
        cv2.line(img, (x, y), (x + l, y), (0, 255, 0), th)
        cv2.line(img, (x, y), (x, y + l), (0, 255, 0), th)
        
        cv2.line(img, (x + l, y), (x + l, y), (0, 255, 0), th)
        cv2.line(img, (x + l, y), (x, y + l), (0, 255, 0), th)

        cv2.line(img, (x, y + l), (x + l, y), (0, 255, 0), th)
        cv2.line(img, (x, y + l), (x, y + l), (0, 255, 0), th)
        return img
    def findCorner(self, img):
        imgRGB = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
        self.result = self.faceDetection.process(imgRGB)
        if self.result.detections:
            for id, detection in enumerate(self.result.detections):
                bboxC = detection.location_data.relative_bounding_box
                ih, iw, ic = img.shape
                bbox = np.array([int(bboxC.xmin * iw), int(bboxC.ymin * ih), \
                       int(bboxC.width * iw), int(bboxC.height * ih)])
        return  bbox[0], bbox[1], bbox[2], bbox[3]
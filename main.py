#!/usr/bin/env python
# coding: utf-8

# In[1]:


import numpy as np
#get_ipython().magic(u'matplotlib inline')
import matplotlib.pyplot as plt
import cv2

import tensorflow as tf
import keras
from keras.models import Sequential, load_model
from keras.layers import Dense, Conv2D, MaxPooling2D, Flatten, Dropout
from keras.losses import categorical_crossentropy
from keras.optimizers import adam, sgd
from keras.preprocessing.image import ImageDataGenerator
from keras.callbacks import ModelCheckpoint

from PIL import Image


# In[2]:


train_path = '../DATASET/TRAIN'
test_path = '../DATASET/TEST'
IMG_BREDTH = 30
IMG_HEIGHT = 60
num_classes = 2


# In[3]:


train_batch = ImageDataGenerator(featurewise_center=False,
                                 samplewise_center=False,
                                 featurewise_std_normalization=False,
                                 samplewise_std_normalization=False,
                                 zca_whitening=False,
                                 rotation_range=45,
                                 width_shift_range=0.2,
                                 height_shift_range=0.2,
                                 horizontal_flip=True,
                                 vertical_flip=False).flow_from_directory(train_path,
                                                                          target_size=(IMG_HEIGHT, IMG_BREDTH),
                                                                          classes=['O', 'R'],
                                                                          batch_size=100)

test_batch = ImageDataGenerator().flow_from_directory(test_path,
                                                      target_size=(IMG_HEIGHT, IMG_BREDTH),
                                                      classes=['O', 'R'],
                                                      batch_size=100)


# In[4]:


def cnn_model():

    model = Sequential()

    model.add(Conv2D(32, kernel_size=(3, 3), padding='same', activation='relu', input_shape=(IMG_HEIGHT,IMG_BREDTH,3)))
    model.add(Conv2D(32, kernel_size=(3, 3), activation='relu'))
    model.add(Conv2D(32, kernel_size=(3, 3), activation='relu'))
    model.add(MaxPooling2D(pool_size=(2, 2)))
    model.add(Dropout(0.25))

    model.add(Conv2D(64, kernel_size=(3, 3), activation='relu'))
    model.add(Conv2D(64, kernel_size=(3, 3), activation='relu'))
    model.add(Conv2D(64, kernel_size=(3, 3), activation='relu'))
    model.add(Dropout(0.25))

    model.add(Flatten())

    model.add(Dense(512, activation='relu'))
    model.add(Dropout(0.5))
    model.add(Dense(512, activation='relu'))
    model.add(Dropout(0.5))

    model.add(Dense(num_classes, activation='softmax'))

    model.summary()

    return model

def use_model(path):

    model = load_model('best_waste_classifier.h5')
    pic = plt.imread(path)
    pic = cv2.resize(pic, (IMG_BREDTH, IMG_HEIGHT))
    pic = np.expand_dims(pic, axis=0)
    classes = model.predict_classes(pic)

#     code using PIL
#     model = load_model('best_waste_classifier.h5')
#     pic1 = plt.imread(path)
#     pic = Image.open(path).resize((IMG_BREDTH, IMG_HEIGHT))
#     plt.imshow(pic1)
#     if model.predict_classes(np.expand_dims(pic, axis=0)) == 0:
#         classes = 'ORGANIC'
#     elif model.predict_classes(np.expand_dims(pic, axis=0)) == 1:
#         classes = 'RECYCLABLE'

    return classes


# In[5]:


model = cnn_model()


# In[6]:


checkpoint = ModelCheckpoint('best_waste_classifier.h5',
                             monitor='val_loss',
                             verbose=0,
                             save_best_only=True,
                             mode='auto')


# In[7]:


model.compile(loss='categorical_crossentropy', optimizer=adam(lr=1.0e-4), metrics=['accuracy'])


# In[8]:


# run code to train the neural network

"""model = model.fit_generator(train_batch,
                            validation_data=test_batch,
                            epochs=100,
                            verbose=1,
                            callbacks=[checkpoint])


# In[10]:"""


print(use_model('/home/user/image.jpg'))

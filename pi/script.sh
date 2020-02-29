#! /bin/bash
python3 ~/tests/cam.py
ssh user@192.168.43.108 << EOF
  cd /home/user/onLoad/Waste-classification/
  python3 main.py |& tail -c3 | head -c1 > ~/a.txt
EOF
scp user@192.168.43.108:~/a.txt .
python3 ~/tests/servo2.py

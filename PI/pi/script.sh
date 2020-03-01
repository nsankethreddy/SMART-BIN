#! /bin/bash
python3 ~/tests/cam.py
# scp user@192.168.43.108:
ssh user@192.168.43.108 << EOF
  cd /home/user/onLoad/Waste-classification/
  python3 main.py |& tail -c3 | head -c1 > ~/a.txt
  cd /home/user/onLoad/
  python3 put_data_in_checked.py
EOF

scp user@192.168.43.108:~/a.txt .
python3 ~/tests/servo2.py
python3 ~/tests/ul.py

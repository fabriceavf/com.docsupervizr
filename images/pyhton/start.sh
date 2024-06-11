#!/bin/bash
echo "running"

pip install --no-cache-dir --upgrade fastapi
pip install --no-cache-dir --upgrade  uvicorn[all]
pip install --no-cache-dir --upgrade -r /fastapi/requirements.txt
while [ true ]
    do
      uvicorn main:app --host 0.0.0.0 --port 80
    done


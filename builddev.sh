# Build a development Docker image using metadata only Dockerfile
echo "Add in Dev Docker metadata" && \
docker build --rm=true -t="bj/bu-accounts-service"  devdocker/ && \
echo "Image built, ready for docker run"
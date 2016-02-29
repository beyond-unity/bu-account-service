# Build it
docker build -t bu-accounts .

# Run local code
docker run --name bu-accounts -it -p 80:80  -v /Users/bobby/code/bu/bu-accounts-service:/srv -d bu-accounts

# Run Code on VM (i.e. what will be published live)
docker run --name myvapingliquid -it -p 80:80  -d myvapingliquid
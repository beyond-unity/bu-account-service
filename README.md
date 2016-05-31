# Build it
```
./builddev.sh
```

# Run local code
```
docker run --name bu-accounts -it -p 80:80 -p 3306:3306 -p 6379:6379 -v $PWD:/srv -d bj/bu-accounts-service
```
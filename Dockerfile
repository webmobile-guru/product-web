FROM mhart/alpine-node:10

RUN apk add --no-cache python make g++
RUN apk add -U tzdata
RUN cp /usr/share/zoneinfo/Asia/Dubai /etc/localtime
ENV TZ=Asia/Dubai
WORKDIR /usr/src/app

COPY package*.json ./

RUN cd /usr/src/app
RUN npm install -g @angular/cli@7.2.2
RUN npm install

WORKDIR /usr/src/app
COPY . .
RUN ng build --prod
RUN ng run frontend:server

CMD ["npm", "run", "server"]

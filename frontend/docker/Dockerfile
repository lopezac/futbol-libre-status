FROM node:22

WORKDIR /frontend

COPY frontend/package.json .

RUN npm install react-scripts -g
RUN npm install -g

COPY frontend/* .

EXPOSE 3000

CMD ["npm", "start"]
var elasticsearch = require("elasticsearch");

var client = new elasticsearch.Client({
  hosts: ["http://localhost:9200"]
});

client.cluster.health({}, function(error, response, status) {
  console.log("Errors:", error, "\n");
  console.log("Cluster health:", response, "\n");
  console.log("Status:", status, "\n");
});

/**
 * Create Index
 * {
 *      index: "company"
 * }
 */
exports.createIndex = ESJson => {
  const { index } = ESJson;
  return new Promise((resolve, reject) => {
    client.indices.create(
      {
        index
      },
      function(err, resp, status) {
        if (err) {
          reject(err);
        } else {
          resolve(resp);
        }
      }
    );
  });
};

/**
 * Create Index
 * {
 *      index: "company_test"
 * }
 */
exports.deleteindex = ESJson => {
  const index = { ESJson };
  return new Promise((resolve, reject) => {
    client.indices.delete({ index }, function(err, resp, status) {
      if (err) reject(err);
      else resolve(resp);
    });
  });
};

/**
 * index: "company_test",
      type: "card",
      body: {
        query: {
          match: { question: "question" }
        }
      }
 */
exports.search = ESJson => {
  const { index, type, body } = ESJson;
  return new Promise((resolve, reject) => {
    client.search(
      {
        index,
        type,
        body
      },
      function(err, resp, status) {
        if (err) reject(err);
        else resolve(resp);
      }
    );
  });
};

/**
 * {
      index: "company_test",
      type: "card",
      body: cardBody
    }
 */

exports.createCard = ESJson => {
  const { index, type, body } = ESJson;
  return new Promise((resolve, reject) => {
    client.index(
      {
        index,
        type,
        body
      },
      function(err, resp, status) {
        if (err) reject(err);
        else resolve(resp);
      }
    );
  });
};

/**
 * {
      index: "company_test",
      type: "card",
      body: body
    }
 */
exports.updateCard = ESJson => {
  const { index, id, type, body } = ESJson;
  return new Promise((resolve, reject) => {
    client.update(
      {
        index,
        id,
        type,
        body
      },
      function(err, resp, status) {
        if (err) reject(err);
        else resolve(resp);
      }
    );
  });
};

/**
 * {
      index: "company_test",
      id: cardId, //id input
      type: "card"
    }
 */

exports.deleteCard = ESJson => {
  const { index, id, type } = ESJson;
  return new Promise((resolve, reject) => {
    client.delete(
      {
        index,
        id,
        type
      },
      function(err, resp, status) {
        if (err) reject(err);
        else resolve(resp);
      }
    );
  });
};

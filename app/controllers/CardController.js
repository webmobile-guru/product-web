const ElasticService = require("../services/ElasticService");

/**
 * Create Index
 */

exports.createIndex = async function(req, res) {
  if (!checkProps(req.body, "index")) return ReE(res, "Missing properties for endpoint", 400);
  const { index } = req.body;

  let ESJson = { index };
  let err, newIndex;

  [err, newIndex] = await to(ElasticService.createIndex(ESJson));
  if (err) return ReE(res, "Err creating Index: " + err.message, 500);

  return ReS(
    res,
    {
      newIndex
    },
    201
  );
};

/**
 * Delete Index
 */

exports.deleteIndex = async function(req, res) {
  if (!checkProps(req.body, "index")) return ReE(res, "Missing properties for endpoint", 400);
  const { index } = req.body;

  let ESJson = { index };
  let err, removedIndex;

  [err, removedIndex] = await to(ElasticService.deleteindex(ESJson));
  if (err) return ReE(res, "Err deleting Index: " + err.message, 500);

  return ReS(
    res,
    {
      removedIndex
    },
    201
  );
};

/**
 * CreateCard
 */

exports.createCard = async function(req, res) {
  if (!checkProps(req.body, "index|type|body")) return ReE(res, "Missing properties for endpoint", 400);
  const { index, type, body } = req.body;

  let ESJson = { index, type, body };
  let err, newCard;

  [err, newCard] = await to(ElasticService.createCard(ESJson));
  if (err) return ReE(res, "Err creating card: " + err.message, 500);

  return ReS(
    res,
    {
      newCard
    },
    201
  );
};

/**
 * UpdateCard
 */
exports.updateCard = async function(req, res) {
  if (!checkProps(req.body, "index|type|body|id")) return ReE(res, "Missing properties for endpoint", 400);
  const { index, id, type, body } = req.body;

  let ESJson = { index, id, type, body };
  let err, updatedCard;

  [err, updatedCard] = await to(ElasticService.updateCard(ESJson));
  if (err) return ReE(res, "Err updating card: " + err.message, 500);

  return ReS(
    res,
    {
      updatedCard
    },
    201
  );
};

/**
 * deleteCard
 */
exports.deleteCard = async function(req, res) {
  if (!checkProps(req.body, "index|type|body|id")) return ReE(res, "Missing properties for endpoint", 400);
  const { index, id, type } = req.body;

  let ESJson = { index, id, type };
  let err, removedCard;

  [err, updatedCard] = await to(ElasticService.updateCard(ESJson));
  if (err) return ReE(res, "Err removing card: " + err.message, 500);

  return ReS(
    res,
    {
      removedCard
    },
    201
  );
};

/**
 * deleteCard
 */
exports.search = async function(req, res) {
  if (!checkProps(req.body, "index|type|body")) return ReE(res, "Missing properties for endpoint", 400);
  const { index, type, body } = req.body;

  let ESJson = { index, type, body };
  let err, removedCard;

  [err, searchResult] = await to(ElasticService.search(ESJson));
  if (err) return ReE(res, "Err searching: " + err.message, 500);

  return ReS(
    res,
    {
      removesearchResultdCard
    },
    201
  );
};

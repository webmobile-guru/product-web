const tagService = require('../services/TagService');

exports.create = async function(req, res) {
    if (!checkProps(req.body, "name")) return ReE(res, 'Missing properties for endpoint', 400);
    let user = req.user;
    let company = user.company;
    let tagJson = req.body;
    tagJson.company = company;
    let err, newTag;

    [err, newTag] = await to(tagService.create(tagJson));
    if (err) return ReE(res, 'Err creating tag: ' + err.message , 500);

    return ReS(res, {
        tagJson
    }, 201);
}

exports.delete = async function (req, res) {
    const user = req.user;
    let err, _;
    tagId = req.body.tagId;
    [err, _] = await to(tagService.deleteTag(tagId));
    if (err) return ReE(res, err)
    return ReS(res, {
        message: 'Tag successfully deleted',
    }, 200);
}





//TODO - create bulk, delete bulk, get/query, delete, update
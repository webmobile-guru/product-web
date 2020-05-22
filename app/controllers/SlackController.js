const SlackService = require("../services/SlackService");

/**
 * 	sample request body:
 * {
 * 		"channelName": "random",
 * 		"blocks": [{"type": "section", "text": {"type": "plain_text", "text": "Hello world"}}]
 * }
 */
exports.postMessage = async function(req, res) {
  if (!checkProps(req.body, "blocks|channelName")) return ReE(res, "Missing properties for endpoint", 400);

  const { blocks, channelName } = req.body;
  const SlackJson = { blocks, channelName };

  [err, result] = await to(SlackService.postMessage(SlackJson));
  if (err) return ReE(res, "Err posting Slack Message: " + err.message, 500);

  return ReS(
    res,
    {
      result
    },
    201
  );

  return ReS(
    res,
    {
      userJson: updatedUser.toWeb()
    },
    200
  );
};
/*exports.addToSlack = async function (req, res) {
    if (!checkProps(req.query, "code")) return ReE(res, 'Missing properties for endpoint', 400);
    var code = req.query.code;
    var redirectURL = 'https://slack.com/api/oauth.access?code='
            +req.query.code+
            '&client_id='+process.env.CLIENT_ID+
            '&client_secret='+process.env.CLIENT_SECRET+
            '&redirect_uri='+process.env.REDIRECT_URI;

    axios.get(redirectURL)
      .then(res => {
            var JSONresponse = JSON.parse(res.data);
            if (!JSONresponse.ok){
                console.log(JSONresponse)
                return ReE(res, "Error encountered: \n"+JSON.stringify(JSONresponse), 422);
            }else{
                console.log(JSONresponse)
            }
      }).catch(err => {
            return ReE(res, err, 422);
      })

    return ReS(res, 201);
}*/

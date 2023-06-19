<!-- Article Card Generator -->
<?php
class ACGenerator
{
    public function createCard(int $id, int $userID, string $title, string $date, $tags, int $goods)
    {

        require_once("./php/DBManager.php");
        $db = new DBManager();
        $userData = $db->getUser($userID);

        $userpic = glob("./img/userpics/" . $userID . "/userpic*");
        if ($userpic) {
            $userpic = $userpic[0];
        } else {
            $userpic = "./img/user_default.png";
        }

        $topimg = glob("./img/article/" . $id . "/topimage*");
        if ($topimg) {
            $topimg = $topimg[0];
        } else {
            $topimg = "./img/article_default.png";
        }

        echo '
            <div class="col-md-6 col-12">
                    <div class="row border-start border-end border-dark border-1 p-2 h-100">
                        <div class="col-7">
                            <h3 class="text-truncate"><a href="./article?id=' . $id . '">' . $title . '</a></h3>
                            <div class="d-flex justify-content-between">
                                <p>' . $date . '</p>
                                <p><i class="fa-solid fa-thumbs-up me-1"></i>1234</p>
                            </div>
                            <div class="tag-area">
            ';

        foreach ($tags as $key => $value) {
            echo '<a href="./search?type=0&word=' . $value['tag_name'] . '" class="d-inline-block me-1">' . $value['tag_name'] . '</a>';
        }

        echo '
                            </div>
                            <div class="row align-items-end" style="min-height: 10vmax;">
                                <div class="col-4">
                                    <img src="' . $userpic . '" class="rounded-circle ratio ratio-1x1">
                                </div>
                                <div class="col-8">
                                    <div>
                                        <div>' . $userData['user_name'] . '</div>
                                            <div class="followButtonContainer-' . $userID . '">
            ';
        $isFollowing = $db->isFollowingUser($_SESSION['user_id'], $userID);
        if ($isFollowing) {
            echo '<button onclick="unfollowUser(' . $userID . ')">フォロー解除する</button>';
        } else {
            echo '<button onclick="followUser(' . $userID . ')">フォローする</button>';
        }
        echo '                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <img src="' . $topimg . '" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            ';
    }
}
?>

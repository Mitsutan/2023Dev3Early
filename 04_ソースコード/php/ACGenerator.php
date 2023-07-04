<?php
// Article Card Generator
class ACGenerator
{
    public function createCard(int $id, int $userID, string $userName, string $title, string $date, $tags, int $goods, bool $isFollowing ,bool $isGoodsIcon)
    {

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
            <div class="col-md-6 col-12 fade-in">
                    <div class="row border-start border-end border-dark border-1 p-2 h-100">
                        <div class="col-7">
                            <h4 class="text-truncate"><a href="./article?id=' . $id . '">' . $title . '</a></h4>
                            <div class="d-flex justify-content-between articleGoodsContainer' . $id . '">
                                <p>' . $date . '</p>
                                <p onclick = "clickGoods(' . $id . ')" class="good-counter">';
        if($isGoodsIcon) {
            echo '<i class="fa-thumbs-up me-1 fa-solid" id="goodsIcon' . $id . '"></i><span id = "goodsCnt' . $id . '">' . $goods . '</span></p>';
        }else {
            echo '<i class="fa-thumbs-up me-1 fa-regular" id="goodsIcon' . $id . '"></i><span id = "goodsCnt' . $id . '">' . $goods . '</span></p>';
        }
        echo '              </div>
                            <div class="tag-area">
            ';

        foreach ($tags as $key => $value) {
            echo '<a href="./search?type=0&word=' . $value['tag_name'] . '" class="d-inline-block me-1">' . $value['tag_name'] . '</a>';
        }

        echo '
                            </div>
                            <div class="row align-items-center mt-1">
                                <div class="col-4">
                                    <img src="' . $userpic . '" class="rounded-circle ratio ratio-1x1">
                                </div>
                                <div class="col-8">
                                    <div>
                                        <div><a href="./profile?id='.$userID.'">' . $userName . '</a></div>
                                            <div class="followButtonContainer-' . $userID . '">
            ';
        if ($isFollowing) {
            echo '<button class="btn btn-primary btn-sm" onclick="unfollowUser(' . $userID . ')">フォロー解除する</button>';
        } else {
            echo '<button class="btn btn-outline-primary btn-sm" onclick="followUser(' . $userID . ')" '. ((!isset($_SESSION['user_id']) || $userID == $_SESSION['user_id'])? "disabled" : "") .'>フォローする</button>';
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

<!-- Article Card Generator -->
<?php
class ACGenerator
{
    public function createCard(int $id, string $title, string $date, string $tags, int $goods)
    {

        $userpic = glob("./img/userpics/" . $_GET["id"] . "/userpic*");
        if ($userpic) {
            $userpic = $userpic[0];
        } else {
            $userpic = "./img/user_default.png";
        }

        echo '
            <div class="col-6">
                    <div class="row border-start border-end border-dark border-1 p-2">
                        <div class="col-7">
                            <h3><a href="./article?id=' . $id . '">' . $title . '</a></h3>
                            <div class="d-flex justify-content-between">
                                <p>' . $date . '</p>
                                <p><i class="fa-solid fa-thumbs-up me-1"></i>1234</p>
                            </div>
                            <div class="tag-area">
                                <a href="./search?type=0&word=ダイエット" class="d-inline-block">ダイエット</a>
                            </div>
                            <div class="row align-items-end" style="min-height: 10vmax;">
                                <div class="col-3">
                                    <img src="' . $userpic . '" class="rounded-circle ratio ratio-1x1">
                                </div>
                                <div class="col-9">
                                    <div>
                                        <div>ユーザー名</div>
                                        <div>フォローする</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <img src="kawaii.jpg" class="w-100 h-100">
                        </div>
                    </div>
                </div>
            ';
    }
}
?>

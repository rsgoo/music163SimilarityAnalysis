#### 网易云音乐用户歌单内容相似度分析 :)

#### music.163.com

---
**简介**：

这是一个比较云音乐用户歌单中包含歌曲的相似度的小应用程序。通过正则表达式抓取页面的歌曲信息进行比较得出两个歌单的相似度。

相似度计算公式参照PHP [similar_text()](http://php.net/manual/zh/function.similar-text.php)函数

>  *相似度 = (A∩B)*2 / (A+B)



**安装/使用**：

>1: clone https://github.com/inscode/music163SimilarityAnalysis.git 到web目录下

>2：在浏览器中进入music163SimilarityAnalysis，如何两个两个你需要比较的歌单url即可

![](https://static.oschina.net/uploads/img/201611/28190241_fRgv.png)


**程序效果**
![image](https://static.oschina.net/uploads/img/201611/28184148_rdMY.png)

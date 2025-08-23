<?php
require_once plugin_dir_path(__FILE__) . 'Decorations.php';
require_once plugin_dir_path(__FILE__) . 'Shapes.php';

class DIPI_ImageMask extends DIPI_Builder_Module
{

    public $slug = 'dipi_image_mask';
    public $vb_support = 'on';
    private $decorations = null;
    private $shapes = null;
    private static $layerID = 0;
    private function getLayerId($prefix = 'SVG_')
    {
        self::$layerID++;
        return $prefix . self::$layerID;
    }
    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/image-mask',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->decorations = new DIPI_SVG_Decorations();
        $this->shapes = new DIPI_SVG_Shapes();
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Image Mask', 'dipi-divi-pixel');

        add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
    }

    public function default_helpers($helpers)
    {
        $helpers['defaults']['dipi_image_mask'] = [
            'image' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAAPoCAIAAADCwUOzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAJLJJREFUeNrs3WlTYtfagGEEnCfaVltbq86XU5X//3NOUkn6JKkekh6dUBl812HF9e5sxAYU2Buu6wOFtgK93encLBcPS2/evKkAAADFVnUIAABAuAMAAMIdAACEOwAAINwBAADhDgAAwh0AABDuAACAcAcAAOEOAAAIdwAAEO4AAIBwBwAAhDsAAAh3AABAuAMAAMIdAACEOwAAINwBAADhDgAAwh0AABDuAAAg3AEAAOEOAAAIdwAAEO4AAIBwBwAAhDsAAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AABDuAAAg3AEAAOEOAAAIdwAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAABDuAACAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQBAuAMAAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAIQ7AAAIdwAAQLgDAIBwBwAAhDsAACDcAQBAuAMAAMIdAAAQ7gAAINwBAADhDgAAwh0AABDuAACAcAcAAOEOAAAIdwAAQLgDAIBwBwAAhDsAACDcAQBAuAMAAMIdAACEOwAAINwBAADhDgAAwh0AABDuAACAcAcAAOEOAAAIdwAAEO4AAIBwBwAAhDsAAAh3AABAuAMAAMIdAACEOwAAINwBAADhDgAAwh0AABDuAAAg3AEAAOEOAAAIdwAAEO4AAIBwBwAAhDsAAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AABDuAAAg3AEAAOEOAAAIdwAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAId4cAAACEOwAAINwBAEC4AwAAwh0AABDuAAAg3AEAAOEOAAAIdwAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AABDuAAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAABDuAACAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAIQ7AAAIdwAAQLgDAIBwBwAAhDsAACDcAQBAuAMAAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAOEOAAAIdwAAQLgDAIBwBwAAhDsAACDcAQBAuAMAAMIdAACEOwAAINwBAADhDgAAwh0AABDuAACAcAcAAOEOAAAIdwAAQLgDAIBwBwAAhDsAACyUukMAFMHd3Z2DQGEtLS05CIBwB5S6cKfQJ2q1Ws2enzHiw+Wgk/aRPwIQ7kDRxda5u5c+jH/a7XZXV1dDHtV7wpWYPukrYcrCOdlutzudTrhyc3OTzsMU5Y+cnKodEO5AicUKz6VPuLKxsbG5ubm+vh5i3VGiaCdtTPPQ7s1m8+rqKlyGml/qSYHuuSUg3IH56Z5KZg0yFnzI9BcvXuzs7Igeii+crps94frFxcXnz59z+d6/Hg8g3IEyebDau91uSPZGo2GJnbKcwFlbW1uh4M/Ozr58+ZJW3LNXtDsg3IGSyRVMXGiv1+unp6fLy8uOD6UO+t3d3VDw79+/v7m5qWRewqHagYmy4gVMKm7Sa/iitbW1k5MT1c58qNVqx8fHId+zr9/odruODCDcgRILWbO9vR0qJ7TOg3/qEFHwE/jh/4NWq4eHh3t7e6HXc7tlHDRAuAMlkB24ETe1b2xsHBwcDKoZlUMpTulBGj2p3Sv/nKEEINyB4krVEq8sLy8fHh46LMyxvb298Ow0tbtqB4Q7UJpwr2TGPr5+/doAGebb0tLSq1evwnPU3FuMAQh3oAS6PQcHB/W66VUswP9Nq9XQ7nHR3WwZQLgDJZDdKrC6uhrfs0bEsAjCCZ8dMuO0B4Q7UI58j8vt8UPbBlgQ+/v7abeMowEId6DQvV7JTJJZW1vLfh7mXr1e393djdPc5Tsg3IES5Huws7OTPmPFncWxvb0t2QHhDpSj2lO+OBosoLW1tdwYJU9cAeEOFDTcu91u2iQzXvRDqW1ubrbb7excVMcEeBbGtAHPluzpysbGxhi3sLS0FKL/4uLi+vpa6zBb4cnn9vb2eG9BEML97Ows/rdguR0Q7kBB2z29W+oY3x6S/ddff221Wks9jiczEZ9AhtO4Vqv961//ajQao/Z3OP/jLeS6X8cDwh0oXL6P8aZLt7e3v/zyS/xe4c5sheCOT0HDM8kffvhh1N8gheKP78GUK3VnNSDcgUJIpVLpDcUb9ds/fPgQi6faI3GY7ZPPoNPphPPw7du3//73v4f5lnTShvM/bXB3JgPCHSho61TGXXFvNpuh18M3xmqXO8z2ZK7c75m5ubkZ8olr9no4k8P3jrdFHkC4A9MrnjF6JW4pDt8YtxkId4rwLDSch61Wa7wb6T+H42+lHF5AuAPFavdRxdaPy+3WKZmtVNjdbvfpzyHThhnVDgh3YK6CKXcFZvXkc+meAwIUhGUtoFjVrpMo1Nk43gnpfZcA4Q7Mfy0JdwpS7QDCHQAAEO5AOdlXAADCHSgBmxMAQLgDZWUZHicegHAHSmC2y/DqzYkHUCjmuAML7cE6zw2mTG+g0/9laeC3ygdAuAOMqb+n04ePp3bujwatv6a31VTtAAh3gKdW+4Ptnn1/nOXl5Xq9Hj7s9IQcD9er1eqDie+9XQEQ7gDPKffWlanXQ6Ovr69vbGysrKzUarUU6EkI95Dvt7e3V1dX19fXrVYrtnv8SntjABDuAM9Z7bnrIbt3dnZCsq+trT3+vdWe5eXlzc3N8OHNzU2z2Tw7O2u32+mNXVO+O9QACHeAp1Z7WnR/8eLF7u5u/+L6oFedZq32hOgP7f7ly5e4rz3lu3YHQLgDPLXaw2Xo9UajUavVHvziIbM77pMJt7O9vf3169dQ8CnZ4x/ZNgOAcAf4vtzrUONCe4j1o6Oj1dXVZ7n9eCXc5suXL7e2tt6/f9/pdOLSe5otAwAT5Q2YgNK7uxevh5JeWVk5OTl5lmrvF2423Hi4i3SncRCNHwQAwh1gYLJX+ja1b21thbCu1yf4G8Vw46enp+GO4j1m36rJDwUA4Q6Ql9uj0u12t7e3X716NZ29K4eHh+Hu4nJ73K5jzwwAwh3gYWnRvdPprK2t7e/vT/Pew92FO+325B4SAAh3gHy7x3dWOjo6mvKad7i7cKdxak1cerfuDoBwB3ig19OV4+PjQWMfJ3Tv8Uq409evX+fG2mh3AIQ7QD6gO53Oq1evVlZWppns2TQPd314eGi3DADCHeDheo7DH1dXV7e2tqZ21w+upocHsLy8HJ5CZGdTAoBwB/g734ODg4MiPJjwMMyWAUC4A/yj11O1r62tra+vF+FRbWxsZN+VyaI7AMId4O9873a7U57/+LiDgwPvogqAcAf4R7UHtVptbW2tOI8qPJjwkOxxB0C4A1TuMjY3Nwv1wMJlfEh2ywAg3AH+Z2lpqdvtbmxsFOohxXDvdDqVzJh5ABDuwOKKQ9MLteIexecS/bPe51j6BUh2kj0Awh1YaNl5Muvr69Vq4f4RCw8pPLAFmS2T+61CnIY5/K8azM0EEO7AQhR8Aas9tftCbZIJf9nV1dWdnZ3sRJ1h8t1WIoCR1B0CoHSZGC9rtVoxH2F4YCFhY77Px6Jy7i8SX2BQyYzSPzw8jD+Or1+/xi9Iq+/elArguVhxB0rZkUUO93q9nn2OMQdy2Z2t9tXV1aOjo/iz2Nvb293djevuuS00TloA4Q4sruXl5YKH+1wGa/ZlBisrK8fHx9k9Sy9fvmw0Grk9M85VAOEOLKjYgkXe4z6vwZqr9pOTk/6fQmz3Tqej3QGelz3uQFnFceke2Kyq/fXr14N+pRDavdLb7x6yPn7NQs3HBJgQK+5AWbVaLQ9s0mJqpxeYxmHtq6urodpza+25ZfW0Z8aJCiDcgQXSv9cifKb4K+5zsMAcyztdxlej5va1D/rLhnbf3d0NRyPlu/nuAMIdmHP9JRfCsbAL2+12e6ROLfiR798hM/yrC/b39xuNRnbIzDDHxJ54AOEOzE/HF3nFPYZ7GZeNc8Wcqj3+0aBXoz4urrtn98zocgDhDiyWZrNZwHYPDyk8sPI+I8p+mOa1hyvLy8uPvBr1cXHdPTdnRr4DCHdgzi3dC+V3eXlZtId3cXGRHmSpj/Mwkx+Hl16r6uWqAMIdWLh8r9VqZ2dnhcrcGO5xBmIcw6Lak729vTH2uwMg3IGy9nols+geKrkg8ZemlZ+fn8fHVtj3hxq12kfdITPoJxJu5MH3VZXvAMIdmP+C73Q6cWtKQeIvPJi47b50a+3Dz2sf8qYGdXx/uwMg3IG5/sertx0lXL5//77SN/9kUDVOSLqX8GDiA0vxWpaCH35e+3hPCXLtHufMmO8OINyBOZcWhkNW3tzcfP36NVt108+7+HjCwwgPJoZ76SrzifPaR2W+O4BwBxai2uNlWnT/8OHDI/uqJ/dIUunGD9Nye/HbfRLz2kdlvjuAcAcWJd/Ta0Bvb28/ffo0w6cQ4fLjx4/tdjvtkyn4cvuE5rWPynx3AOEOLEq7V3tqtdq7d+9mONM93HVcbo/KtUlmEpMfh2e+O4BwB+Y82Sv3i+61ntCab968ub29faRNJyTcabjr+Pwh+8rUUuT7bKs9Mt8dQLgDC/BPWK8yYzR3u90Q0A8u3E6uoeOdhtCs1+u5eTKlq/ZJ75Ax3x1AuAOLKCVmWuoO6Xxzc/Pf//53asEX7ijcXbjT8ADSvp2CL7c/47z2sX9kD3a8+e4Awh1YiIJPm93Pz89//vnndrs96fsNdxHuKNxdfNpQluX2yc1rf2LHV8x3BxDuwHwne+X+Vapxs3u9Xr+6uvrxxx+bzWb/t+RCcOzF3evr63AX4Y5q97KvSS1yR055XvuozHcHEO7APLd7Ntxju7fb7Z9++unbt2+Pd152fvkwURivh5sN1R7uot6TfU1q0RbdizCvfVTmuwMMUncIgLK3ewq7bIN2Op03b95sb28fHx+vr6/3537/9UeeG0Q3Nzdv3749Pz8Pn4zJnqv2Yj6xSdK89mCa89pHtb+/Hx7Y169f0+8x4o/YlhhAuAPMQ7unze7Zz19cXPznP//Z29sL+R5SdaTyS7cZtFqtd+/eff78OS3tpyuVck5+LNQOmX4vX74Ml6Hd469TnOQAwh2Y23aPn+n0hP778uVLo9HY2dnZ3d0dMgTDLYTvPesJ357djZNmyFT++f6pZan2k5OT4j/ZCE+3Yrunn2z2qRSAcAeYh3aPbR2yOy6Nhyvdbvfbt2+hv8Ofbm5uhnxfW1ur1+vLy8vhMnVhu90OX3x7e3t9fR2S8erqqpKZOJlN9vJWe9F2yAzK8TjfPba7PTMAwh2Yt2rPrruHK3HiYRpYHjWbzVDkaXRJ+EzI90pvwmN2PHy20dOH6TJX7bnXuc68L9OhCH+7eBmE5yozmfz43Yf6SMf3tzuAcAcosf5BMWnpPRv08Q1WY8THZM+u46al9/Ri0xSLDyZ79kr//JbZHpDU65VZz2t/YsfHdg+P/9u3b2m/+5B7ZoaZGgQg3AFmJrRdXE2PV1K+xw/Tn2ZrO9v92XDPXu/fFWNe+9SkOTMj7XdX7YBwByi07Ip7dmk8uzcm27X9ydt/WfA3V8pVbFprr2TmtZd9n0lad4+TfCpeqwoId4A5CPdcxaaUz4Z49u05+8M9dz3eZmEzsaTz2kdlvjsg3AHmx6D5JKm/s598PPiy+2dKlIbztEOmn/nugHAHmBPppaiPZP2QFV7GddwyzmsflfnuwMKyXAHMYbsv8l+8sPPan+vnGOe7NxqNOC0nfbGXogLCHYDiyk6RT+PqV1dX52CHTP989+yH/e0OINwBKK40qb1StnntT+z42O67u7vxvaUejPvhbwpAuAMw8Zyd71ejPm5/f7/RaGT3yQzT7hbpAeEOwGT1vz9rNljjq1EXbdZKWnfX5cDcM1UGoDQWZF77qMx3B4Q7AMW1yDtk+pnvDiwC/7oBlL7aF3CHTL+9vb0x9rsDlIgVd4Axuzma/n6MOZvXPsZff9D746Z1d3tmgLlkxR1gtGrMreNO561/5nhe+3iH4sEnURXz3QHhDkC2EcOVer2+ubk5tXfuXJx57U/s+MoT5rsDFJytMgAjVHsM9FDtR0dHtVotpOHl5eVST/zTUNKTyMQFn9c+qjRnJu2rGbTBBqBE/KMPMFq1h14P0RzaPYTg4eFhXHdPsZ4dKP7Eu+uv9soCz2sflfnugHAHWMRkj1dCBYZqD9Ecqj0ldWj3jY2N7KbqpwfioHnt4coiz2sfVXxf1U6nM7UdTQDCHWDG7Z52yGSrPUX2q1evNjc3c+3+XG1t8uNTpNeqPstvQgCEO0ARZbeVh8vcWvt32/0Z98yo9qcw3x0Q7gBzLm1QiS85PT09fbDaU7sfHR31r7s/Y7XbITPM4XrwR2NGJCDcAea8AtOrUU9OTsLld7+rf919VOa1j818d0C4AyxitcdoTtX+yFp7rh1z7T7o1ZCD8tG89gl1fOV+zsxdhqMECHeAcld7jOb+GTIjtXtuU3WuIwdtejGvfaLigEjJDgh3gDmp9kdmyAzf7rkZkUO+VtW89kn/fIU7INwB5iHZKwPmtT9Lu3+3F9PTBvPaJ/fDtU8GEO4A85B3T1xrz7X7g3NmBrW4yY+T4/kPINwB5qTqhpzXPkz65275kfnu2ZpU7dN8elYxyh0Q7gBlNNK89u8+B+j/zKD57v3taF77NNsdQLgDlK/hRp3XPqr+dfe0zTrtz+l0OmbIKHUA4Q7wcM+NN699VA/umalkRk/Gee2qfUL8BgMQ7gDlrvbKE+a1j93uuZEm8bq1dgCEO8DAan/GGTLDt3uaEZmodgCEO8DDyV55pnntT2z3cKnaARDuAAPbfcpr7bl2j3NmvBoVgJHUHQJgQYRiTpMfK0+b1z7GU4Xs6yPjunu46729vVDtj7wrEwAId2DhZOe1h2o/PT2dxOTHQc8Z+j+zv78/6E8BoJ/fzwILYTrz2sd+YAAg3AGmN699DJbbARDuAH9Xe2WK89oBQLgDjFntM5whAwDCHeD7yV6Z0bx2ABDuACO0u7V2AIQ7QEHF16FWZjGvHQCEO8CwsvPaq9Xq6empagdAuAMUS2HntQOAcAf4/2ov7Lx2ABDuAH9Xe8W8dgCEO0Dxq90MGQCEO0Chk71iXjsAwh2g+O1urR0A4Q5QUOa1AyDcAUrAvHYAhDtA0ZnXDoBwByhftVtrB2Du+V8dUO5qPz09tdYOwCKw4g6Ur9rjFTtkABDuAEXP9+Dly5e5HTIp6wFAuAMUIty73e7S0lLu8/2fAQDhDjCzao/iOMj0SUcGAOEOUMR2z37GWjsAwh2giOH+yIcAINwBCiG3vm65HQDhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAGN/d3V26vrS0lPsMgHAHgEKIsZ6N+OxnAIQ7AAAg3AFgLJbbgZKqOwRASbXb7ZubG5uV+W6mh5Mkxnqr1YpXtDsg3AGmlGLBu3fvQrvf3XNYePyEqVartR7VDgh3gKl2WCywbo9jwiNnS1xxj+EeLuP548gAwh1g4h0WLkN+xQ/DFcvtPCJWezptYrg7LIBwB5hSu8f8itUu3Bnmyd7SPQcEEO4A0yiwNIc7XlftDBnuFa9JBYQ7wEzaPeW7Y8LYKQ8g3AFUFwA8J2/ABAAAwh0AABDuAAAg3AFggXjtBCDcAaAE0qTR8b4RQLgDZQ2gkaRa0kCU9+zNfdISPiDcgQJ5ME06nc6ot7OyslLJLHkqHorQ7uFKPDNHFf4T8O5ggHAHCpo42ZRvt9uj3s7W1la2lrrdrmPLTJ6IhtMv+6a84cwc9UbC2SvZgUnwBkzAcxZ8XClvtVpra2sjffuLFy+urq6azWa8hezbo8KUT+NY3nG5/eDgYNQbiU9c02+N/PoIEO5AIaTCzqb2GFtlwrefnp5++vTp8vIydL/cYbb5Xq/Xt7a29vf3q9WRfzU9xm+cAIQ7MI3ESeWdFsubzWaj0Rjj1l72OKqU9L+F+J9A+sURwPOyxx145oIPzs/Pn/HWoAhn9fDOzs6W7jmGgHAHCirtcb++vn767UARzueRvji0frPZdOgA4Q6UIHSCarX69EV3KJG0Nn92dlYx0hQQ7kDxqz0ly+fPn410ZHGSPWX6x48flzIcH0C4A4Wu9jjK/dOnTw4LC3LmR2dnZ9fX19VqVbgDwh0oR8fE3TJ//vnnGHMhoaTu7u7ev3+fXW5Pc2YAhDtQ3GqP068/fPjgmLAgPn36dHt7m5bbHRBAuAPlaPeY7yFlvnz54pgw9y4vL9+9e1e9J9wB4Q4Uvdcr/1x0D/7444/QNI4Pc+z29vbNmzfhbK/VatkV92y+S3lAuANFkZ2tkcI9dEy4Hpqm1WoN+hYo7Pn8yJ+mL+h2u7/++mv4sF6vP7JPxtkOCHegiLKL7qFmQtn89NNPV1dX/V/mWFHYc/i7Z3ilt9b+448/hsv4HNU+GUC4A+UrnhgxcedAaPdOp/Pzzz/b7848ubi4CNXearWyO2RStct3QLgDZWr37Lp7+Mzvv//+9u1bb8xE2d3d3f3111+//PJLuFLLME8GmKi6QwBMtODjXMhYM51O5+PHj58/fz4+Pt7b25M4lNG3b9/C889Wq5V+p5RdcTe7HRDuQPmSPRVMbPf4yU7PH3/88ddffx0eHu7s7MTFeCi4cN6en5//+eefV1dXMdZjr6d97f2TZACEO1C+do+JE9InrsGHK7e3t7/99lv4gs3Nzd3d3XC53JMqH2ar2+222+1Wq3V5eXl2dnZxcRHP6jg9JlV7dmu7ageEOzAP7f6/f3F6E2ZCtYfciVfCnzabzaurq/A1ce97GiLp6DGrMzYIJ2c8IbNvKJYTP5l7NWo84ePtOJ6AcAdKVkKpZuJl6PKQRDF6wpW7e+HD2DpevUoRztv0YtO04yutrz8yQyad8I4hINyBsmZQ/0pkivXsZ7LXHTdm9VQzXc+OSMpxrADhDsxzD6VF99To6TL7IRQt3x/sdfkOCHdgIfI9XY9L76qdIhe8ZAeEO7DQ+V7J7EYQQ5So4wGEO6CBrLtT0JPTmQkId4Chgh6cmcAi80YnACDZAeEOAOVnkwwg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAABDuDgEAAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AABDuAAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQBAuAMAAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAOEOAAAIdwAAQLgDAIBwBwAAhDsAACDcAQBAuAMAAMIdAAAQ7gAAINwBAADhDgAAwh0AABDuAACAcAcAAOEOAAAIdwAAQLgDAIBwBwAAhDsAAAh3AABAuAMAAMIdAACEOwAAINwBAADhDgAAwh0AABDuAACAcAcAAOEOAAAIdwAAEO4AAIBwBwAAhDsAAAh3AABAuAMAAMIdAACEOwAAINwBAEC4AwAAwh0AABDuAAAg3AEAAOEOAAAIdwAAEO4AAIBwBwAAhDsAAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AABDuAAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AABAuAMAgHAHAACEOwAAINwBAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AAIBwBwAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQBAuAMAAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAOHuEAAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAAOEOAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAACEOwAACHcAAEC4AwAAwh0AAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAAh3AAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAg3AEAQLgDAADCHQAAEO4AACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAAEC4AwCAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQAA4Q4AAMIdAAAQ7gAAgHAHAADhDgAACHcAABDuAACAcAcAAIQ7AAAIdwAAQLgDAADCHQAAhDsAACDcAQBAuAMAAMIdAAAQ7gAAINwBAADhDgAACHcAABDuAACAcAcAAIL/E2AAcywVngCOlncAAAAASUVORK5CYII=',
        ];
        return $helpers;
    }

    public function get_settings_modal_toggles()
    {
        $toggles = [
            'general' => [],
        ];
        $toggles['general']['toggles'] = [
            'main_content' => esc_html__('Mask Settings', 'dipi-divi-pixel'),
            'layer_1' => ['title' => esc_html__('Border Layer', 'dipi-divi-pixel')],
            'layer_2' => ['title' => esc_html__('Decoration Element 1', 'dipi-divi-pixel')],
            'layer_3' => ['title' => esc_html__('Decoration Element 2', 'dipi-divi-pixel')],
        ];
        return $toggles;
    }

    public function get_fields()
    {
        $fields = [];

        $fields['image'] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'upload_button_text' => esc_attr__('Upload Image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Chose Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Update Image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'image',
        ];
        $fields["img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'text'
        ];

        $fields['use_custom_mask'] = [
            'label' => esc_html__('Use Custom Mask', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'et_builder'),
                'on' => esc_html__('Yes', 'et_builder'),
            ],
            'default' => 'off',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
        ];

        $thumbs_url = plugins_url('/assets/', __FILE__);
        $fields['shape'] = [
            'label' => esc_html__('Select Mask', 'dipi-divi-pixel'),
            'description' => esc_html__('Select the mask shape you want to use on your image.', 'dipi-divi-pixel'),
            'type' => 'dipi_field_imageselect',
            'subtype' => 'radio',
            'default' => 'Shape1',
            'toggle_slug' => 'main_content',
            'options' => array(
                'Shape1' => $thumbs_url . 'shapes-01.svg',
                'Shape3' => $thumbs_url . 'shapes-03.svg',
                'Shape13' => $thumbs_url . 'shapes-13.svg',
                'Shape14' => $thumbs_url . 'shapes-14.svg',
                'Shape15' => $thumbs_url . 'shapes-15.svg',
                'Shape16' => $thumbs_url . 'shapes-16.svg',
                'Shape4' => $thumbs_url . 'shapes-04.svg',
                'Shape6' => $thumbs_url . 'shapes-06.svg',
                'Shape7' => $thumbs_url . 'shapes-07.svg',
                'Shape17' => $thumbs_url . 'shapes-17.svg',

                'Shape25' => $thumbs_url . 'shapes-25.svg',
                'Shape26' => $thumbs_url . 'shapes-26.svg',
                'Shape27' => $thumbs_url . 'shapes-27.svg',
                'Shape2' => $thumbs_url . 'shapes-02.svg',
                'Shape5' => $thumbs_url . 'shapes-05.svg',
                'Shape12' => $thumbs_url . 'shapes-12.svg',
                'Shape8' => $thumbs_url . 'shapes-08.svg',
                'Shape37' => $thumbs_url . 'shapes-37.svg',
                'Shape24' => $thumbs_url . 'shapes-24.svg',
                'Shape23' => $thumbs_url . 'shapes-23.svg',

                'Shape9' => $thumbs_url . 'shapes-09.svg',
                'Shape10' => $thumbs_url . 'shapes-10.svg',
                'Shape32' => $thumbs_url . 'shapes-32.svg',
                'Shape34' => $thumbs_url . 'shapes-34.svg',
                'Shape35' => $thumbs_url . 'shapes-35.svg',
                'Shape36' => $thumbs_url . 'shapes-36.svg',
                'Shape18' => $thumbs_url . 'shapes-18.svg',
                'Shape19' => $thumbs_url . 'shapes-19.svg',
                'Shape11' => $thumbs_url . 'shapes-11.svg',
                'Shape20' => $thumbs_url . 'shapes-20.svg',

                'Shape21' => $thumbs_url . 'shapes-21.svg',
                'Shape22' => $thumbs_url . 'shapes-22.svg',
                'Shape28' => $thumbs_url . 'shapes-28.svg',
                'Shape39' => $thumbs_url . 'shapes-39.svg',
                'Shape29' => $thumbs_url . 'shapes-29.svg',
                'Shape30' => $thumbs_url . 'shapes-30.svg',
                'Shape33' => $thumbs_url . 'shapes-33.svg',
                'Shape40' => $thumbs_url . 'shapes-40.svg',
                'Shape38' => $thumbs_url . 'shapes-38.svg',
                'Shape31' => $thumbs_url . 'shapes-31.svg',
            ),
            'show_if' => ['use_custom_mask' => 'off'],
        ];
        $fields['custom_mask'] = [
            'label' => esc_html__('Custom Mask', 'dipi-divi-pixel'),
            'type' => 'upload',
            'upload_button_text' => esc_attr__('Upload Image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Chose Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Update Image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'image',
            'show_if' => ['use_custom_mask' => 'on'],
        ];

        $fields['shape_rotate'] = [
            'label' => esc_html__('Rotate Mask', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'default' => '0deg',
            'fixed_unit' => 'deg',
            'range_settings' => [
                'min' => '0',
                'max' => '360',
            ],
        ];

        $fields['shape_scale_x'] = [
            'label' => esc_html__('Mask Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'unitless' => true,
            'default' => '1',
            'range_settings' => [
                'min' => '0',
                'max' => '2',
                'step' => '0.01',
            ],
        ];

        $fields['shape_scale_y'] = [
            'label' => esc_html__('Mask Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'unitless' => true,
            'default' => '1',
            'range_settings' => [
                'min' => '0',
                'max' => '2',
                'step' => '0.01',
            ],
        ];

        $fields['shape_flip'] = [
            'label' => esc_html__('Flip Mask', 'dipi-divi-pixel'),
            'description' => esc_html__('Flip the mask horizontally or vertically to change the shape and its direction.', 'dipi-divi-pixel'),
            'type' => 'multiple_buttons',
            'options' => array(
                'horizontal' => array(
                    'title' => esc_html__('Horizontal', 'dipi-divi-pixel'),
                    'icon' => 'flip-horizontally',
                ),
                'vertical' => array(
                    'title' => esc_html__('Vertical', 'dipi-divi-pixel'),
                    'icon' => 'flip-vertically',
                ),
            ),
            'toggleable' => true,
            'multi_selection' => true,
            'default' => '',
            'toggle_slug' => 'main_content',
        ];

        $fields['image_width'] = [
            'label' => esc_html__('Image Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'default' => '100%',
            'fixed_unit' => '%',
            'range_settings' => [
                'min' => '0',
                'max' => '200',
            ],
        ];

        $fields['image_horz'] = [
            'label' => esc_html__('Image Horizontal Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'default' => '0',
            'unitless' => true,
            'range_settings' => [
                'min' => -1000,
                'max' => 1000,
            ],
        ];

        $fields['image_vert'] = [
            'label' => esc_html__('Image Vertical Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'default' => '0',
            'unitless' => true,
            'range_settings' => [
                'min' => -1000,
                'max' => 1000,
            ],
        ];

        $fields['layer_1_enable'] = [
            'label' => esc_html__('Enable Border Layer', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'et_builder'),
                'on' => esc_html__('Yes', 'et_builder'),
            ],
            'default' => 'off',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_1',
        ];

        $fields['layer_1_background_type'] = [
            'label' => esc_html__('Background Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                esc_html__('Solid Color', 'dipi-divi-pixel'),
                esc_html__('Gradient', 'dipi-divi-pixel'),
            ),
            'default' => 'Solid Color',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_1',
            'data_type' => '',
            'show_if' => array(
                'layer_1_enable' => 'on',
            ),
        ];

        $fields['layer_1_background_color'] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#000',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_1',
            'show_if' => array(
                'layer_1_enable' => 'on',
                'layer_1_background_type' => 'Solid Color',
            ),
        ];

        $fields['layer_1_gradient_color_start'] = [
            'label' => esc_html__('Gradient Color Start', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#fff',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_1',
            'show_if' => array(
                'layer_1_enable' => 'on',
                'layer_1_background_type' => 'Gradient',
            ),
        ];

        $fields['layer_1_gradient_color_end'] = [
            'label' => esc_html__('Gradient Color End', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#fff',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_1',
            'show_if' => array(
                'layer_1_enable' => 'on',
                'layer_1_background_type' => 'Gradient',
            ),
        ];

        $fields['layer_2_enable'] = [
            'label' => esc_html__('Enable Decoration Element', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'et_builder'),
                'on' => esc_html__('Yes', 'et_builder'),
            ],
            'default' => 'off',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
        ];

        $fields['docration_element_1'] = [
            'label' => esc_html__('Decoraction Element', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'DottedSquare' => esc_html__('Dotted Square', 'dipi-divi-pixel'),
                'DottedCircle' => esc_html__('Dotted Circle', 'dipi-divi-pixel'),
                'DottedTraingle' => esc_html__('Dotted Traingle', 'dipi-divi-pixel'),
                'DottedShape' => esc_html__('Dotted Shape', 'dipi-divi-pixel'),
                'StrokeTriangle' => esc_html__('Stroke Triangle', 'dipi-divi-pixel'),
                'StrokeCircle' => esc_html__('Stroke Circle', 'dipi-divi-pixel'),
                'StrokeSquare' => esc_html__('Stroke Square', 'dipi-divi-pixel'),
                'AbstractSquare' => esc_html__('Abstract Square', 'dipi-divi-pixel'),
                'AbstractCircle' => esc_html__('Abstract Circle', 'dipi-divi-pixel'),
                'FilledCircle' => esc_html__('Filled Circle', 'dipi-divi-pixel'),
                'FilledSquare' => esc_html__('Filled Square', 'dipi-divi-pixel'),
                'FilledTriangle' => esc_html__('Filled Triangle', 'dipi-divi-pixel'),
                'LinedSquare' => esc_html__('Lined Square', 'dipi-divi-pixel'),
                'LinedCircle' => esc_html__('Lined Circle', 'dipi-divi-pixel'),
                'LinedTriangle' => esc_html__('Lined Triangle', 'dipi-divi-pixel'),
            ),
            'default' => 'LinedCircle',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
            'show_if' => array(
                'layer_2_enable' => 'on',
            ),
        ];

        $fields['layer_2_above_image'] = [
            'label' => esc_html__('Show Above Image', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'et_builder'),
                'on' => esc_html__('Yes', 'et_builder'),
            ],
            'default' => 'on',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
            'show_if' => array(
                'layer_2_enable' => 'on',
            ),
        ];

        $fields['layer_2_background_color'] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#000',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
            'show_if' => array(
                'layer_2_enable' => 'on',
            ),
        ];

        $fields['layer_2_horz'] = [
            'label' => esc_html__('Horizontal Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
            'default' => '25%',
            'fixed_unit' => '%',
            'range_settings' => [
                'min' => -100,
                'max' => 100,
            ],
            'show_if' => array(
                'layer_2_enable' => 'on',
            ),
        ];

        $fields['layer_2_vert'] = [
            'label' => esc_html__('Vertical Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
            'default' => '-25%',
            'fixed_unit' => '%',
            'range_settings' => [
                'min' => -100,
                'max' => 100,
            ],
            'show_if' => array(
                'layer_2_enable' => 'on',
            ),
        ];

        $fields['layer_2_scale'] = [
            'label' => esc_html__('Scale', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
            'default' => '1',
            'unitless' => true,
            'range_settings' => [
                'step' => '0.01',
                'min' => '-3',
                'max' => '3',
            ],
            'show_if' => array(
                'layer_2_enable' => 'on',
            ),
        ];

        $fields['layer_2_rotate'] = [
            'label' => esc_html__('Rotate', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_2',
            'default' => '0',
            'unitless' => true,
            'range_settings' => [
                'step' => '1',
                'min' => '0',
                'max' => '360',
            ],
            'show_if' => array(
                'layer_2_enable' => 'on',
            ),
        ];

        $fields['layer_3_enable'] = [
            'label' => esc_html__('Enable Decoration Element', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'et_builder'),
                'on' => esc_html__('Yes', 'et_builder'),
            ],
            'default' => 'off',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
        ];

        $fields['docration_element_2'] = [
            'label' => esc_html__('Decoraction Element', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'StrokeTriangle' => esc_html__('Stroke Triangle', 'dipi-divi-pixel'),
                'StrokeCircle' => esc_html__('Stroke Circle', 'dipi-divi-pixel'),
                'StrokeSquare' => esc_html__('Stroke Square', 'dipi-divi-pixel'),
                'DottedSquare' => esc_html__('Dotted Square', 'dipi-divi-pixel'),
                'DottedCircle' => esc_html__('Dotted Circle', 'dipi-divi-pixel'),
                'DottedTraingle' => esc_html__('Dotted Traingle', 'dipi-divi-pixel'),
                'DottedShape' => esc_html__('Dotted Shape', 'dipi-divi-pixel'),
                'AbstractSquare' => esc_html__('Abstract Square', 'dipi-divi-pixel'),
                'AbstractCircle' => esc_html__('Abstract Circle', 'dipi-divi-pixel'),
                'FilledCircle' => esc_html__('Filled Circle', 'dipi-divi-pixel'),
                'FilledSquare' => esc_html__('Filled Square', 'dipi-divi-pixel'),
                'FilledTriangle' => esc_html__('Filled Triangle', 'dipi-divi-pixel'),
                'LinedSquare' => esc_html__('Lined Square', 'dipi-divi-pixel'),
                'LinedCircle' => esc_html__('Lined Circle', 'dipi-divi-pixel'),
                'LinedTriangle' => esc_html__('Lined Triangle', 'dipi-divi-pixel'),
            ),
            'default' => 'LinedCircle',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
            'show_if' => array(
                'layer_3_enable' => 'on',
            ),
        ];

        $fields['layer_3_above_image'] = [
            'label' => esc_html__('Show Above Image', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'et_builder'),
                'on' => esc_html__('Yes', 'et_builder'),
            ],
            'default' => 'on',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
            'show_if' => array(
                'layer_3_enable' => 'on',
            ),
        ];

        $fields['layer_3_background_color'] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#000',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
            'show_if' => array(
                'layer_3_enable' => 'on',
            ),
        ];

        $fields['layer_3_horz'] = [
            'label' => esc_html__('Horizontal Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
            'default' => '-15%',
            'fixed_unit' => '%',
            'range_settings' => [
                'min' => -100,
                'max' => 100,
            ],
            'show_if' => array(
                'layer_3_enable' => 'on',
            ),
        ];

        $fields['layer_3_vert'] = [
            'label' => esc_html__('Vertical Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
            'default' => '30%',
            'fixed_unit' => '%',
            'range_settings' => [
                'min' => -100,
                'max' => 100,
            ],
            'show_if' => array(
                'layer_3_enable' => 'on',
            ),
        ];

        $fields['layer_3_scale'] = [
            'label' => esc_html__('Scale', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
            'default' => '1',
            'unitless' => true,
            'range_settings' => [
                'step' => '0.1',
                'min' => '-3',
                'max' => '3',
            ],
            'show_if' => array(
                'layer_3_enable' => 'on',
            ),
        ];

        $fields['layer_3_rotate'] = [
            'label' => esc_html__('Rotate', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'layer_3',
            'default' => '0',
            'unitless' => true,
            'range_settings' => [
                'step' => '1',
                'min' => '0',
                'max' => '360',
            ],
            'show_if' => array(
                'layer_3_enable' => 'on',
            ),
        ];
        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [
            'text' => false,
            'text_shadow' => false,
            'fonts' => false,
        ];

        $advanced_fields['background'] = [
            'css' => [
                'main' => '%%order_class%% .fake-class',
            ],
            'hover' => false,
            'hover_enabled' => 'off',
            'background__hover_enabled' => 'off',
            'use_background_video' => false,
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        if ($this->props["layer_1_enable"] === 'on' && $this->props["layer_1_background_type"] === 'Solid Color') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .st1',
                'declaration' => "fill:" . $this->props["layer_1_background_color"],
            ]);
        }

        if ($this->props["layer_2_enable"] === 'on') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .s02',
                'declaration' => "fill:" . $this->props["layer_2_background_color"],
            ]);
        }

        if ($this->props["layer_3_enable"] === 'on') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .s03',
                'declaration' => "fill:" . $this->props["layer_3_background_color"],
            ]);
        }

        $layerZeroGradient = '';
        $layerOneGradient = '';

        $gradId2 = $this->getLayerId('GRAD_');

        if ($this->props["layer_1_enable"] === 'on' && $this->props["layer_1_background_type"] === 'Gradient') {
            $layerOneGradient = sprintf('
        <defs>
          <linearGradient id="%3$s" x1="0%%" y1="0%%" x2="100%%" y2="0%%">
            <stop offset="0%%" style="stop-color: %1$s;stop-opacity: 1" />
            <stop offset="100%%" style="stop-color: %2$s;stop-opacity: 1" />
          </linearGradient>
        </defs>',
                $this->props["layer_1_gradient_color_start"],
                $this->props["layer_1_gradient_color_end"],
                $gradId2
            );

        }

        $style = '';
        $deco_1 = '';
        $deco_2 = '';
        $bottom_layers = '';
        $top_layers = '';

        if ($this->props["layer_2_enable"] === 'on') {
            $deco_1 = $this->decorations->decoration($this->props["docration_element_1"], "s02", $this->props["layer_2_horz"], $this->props["layer_2_vert"], $this->props["layer_2_scale"], $this->props["layer_2_rotate"]);
        }

        if ($this->props["layer_3_enable"] === 'on') {
            $deco_2 = $this->decorations->decoration($this->props["docration_element_2"], "s03", $this->props["layer_3_horz"], $this->props["layer_3_vert"], $this->props["layer_3_scale"], $this->props["layer_3_rotate"]);
        }

        if ($this->props["layer_2_above_image"] === 'on') {
            $top_layers .= $deco_1;
        } else {
            $bottom_layers .= $deco_1;
        }

        if ($this->props["layer_3_above_image"] === 'on') {
            $top_layers .= $deco_2;
        } else {
            $bottom_layers .= $deco_2;
        }

        $main_layer = $this->shapes->shape(
            $this->props['shape'],
            [
                'image' => $this->props['image'],
                'image_width' => $this->props['image_width'],
                'image_horz' => $this->props['image_horz'],
                'image_vert' => $this->props['image_vert'],
                'shape_rotate' => $this->props['shape_rotate'],
                'shape_scale_x' => $this->props['shape_scale_x'],
                'shape_scale_y' => $this->props['shape_scale_y'],
                'shape_flip' => $this->props['shape_flip'],
                'use_custom_mask' => $this->props['use_custom_mask'],
                'custom_mask' => $this->props['custom_mask'],
            ],
            $this->props['layer_1_enable'],
            $gradId2
        );

        $title_id = 'alt-text-' . uniqid();
        return sprintf(
            '<div class="dipi-image-mask--mask">
                <svg width="100%%" height="100%%"  style="overflow:visible" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1000 1000" aria-labelledby="%7$s" role="img">
                    <title id="%7$s">%6$s</title>
                    %1$s
                    <style>%2$s</style>
                    %3$s
                    %4$s
                    %5$s
                </svg>
            </div>',
            $layerOneGradient, // #1
            $style,
            $bottom_layers,
            $main_layer,
            $top_layers, // #5
            $this->props['img_alt'],
            $title_id

        );
    }

}
new DIPI_ImageMask;

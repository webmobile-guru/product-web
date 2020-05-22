using System;
using System.IO;
using System.Management;
using System.Net;
using System.Text;

namespace LicenceApp
{
    public class Licence
    {
        private static string _register;

        public static string GetSerialNo()
        { 
            //Licence._register = "http://www.techprosoftware.com/LicenceApp/ProductVerification.aspx?SID=";
            //Licence._register = "http://localhost:54152/ProductVerification.aspx?SID=";
            Licence._register = "https://ducklicenseserver.azurewebsites.net/ProductVerification.aspx?SID=";
            /* object obj = (object)new ManagementObjectSearcher("SELECT * FROM Win32_baseboard");

             string empty = string.Empty;
             ManagementClass diskClass = new ManagementClass("win32_logicaldisk");
             ManagementObjectCollection disks = diskClass.GetInstances();
             ManagementObjectCollection.ManagementObjectEnumerator disksEnumerator = disks.GetEnumerator();
             while (disksEnumerator.MoveNext())
             {
                 ManagementObject disk = (ManagementObject)disksEnumerator.Current;
                 empty = disksEnumerator.Current.Properties["processorID"].Value.ToString();
             }*/
            //using (ManagementObjectCollection.ManagementObjectEnumerator enumerator = new ManagementClass("win64_processor").GetInstances().GetEnumerator())
            // {
            //     if (enumerator.MoveNext())
            //          empty = enumerator.Current.Properties["processorID"].Value.ToString();
            //  }

            var mbs = new ManagementObjectSearcher("Select ProcessorID From Win32_processor");
            var mbsList = mbs.Get();

            string empty = string.Empty;

            foreach (ManagementObject mo in mbsList)
            {
                empty = mo["ProcessorID"].ToString();
                //textBox1.Text = cpuid;
            }

            ManagementObject managementObject = new ManagementObject("win32_logicaldisk.deviceid=\"C:\"");
            managementObject.Get();
            string str = managementObject["VolumeSerialNumber"].ToString();
            return empty + str;
            //return "BFEBFBFF000806EB784092B4";
        }

        public static bool CheckProduct(string emailId, string productID,string productIDRoot)
        {
            bool status = false;
            string serialNo = Licence.GetSerialNo();
            var data = Licence.Gethtml(Licence._register + serialNo.Trim() + "&EmailID=" + emailId + "&PID=" + productID + "&PIDRoot=" + productIDRoot);
            if (data.Contains("Query Success"))
            {
                status = true;
            }
            else
            {
                string b = data;
            }
           
            return status;
        }

        private static string Gethtml(string a)
        {
            string str;
            try
            {
                ServicePointManager.Expect100Continue = true;
                ServicePointManager.SecurityProtocol = SecurityProtocolType.Tls11 | SecurityProtocolType.Tls12;

                HttpWebRequest httpWebRequest = (HttpWebRequest)WebRequest.Create(a);
                httpWebRequest.Method = "GET";
                httpWebRequest.AllowAutoRedirect = true;
                HttpWebResponse response = (HttpWebResponse)httpWebRequest.GetResponse();
                Stream responseStream = response.GetResponseStream();
                Encoding utF8 = Encoding.UTF8;
                StreamReader streamReader = new StreamReader(responseStream, utF8);
                string end = streamReader.ReadToEnd();
                responseStream.Close();
                streamReader.Close();
                response.Close();
                str = end;
            }
            catch (Exception ex)
            {
                //if (Licence.counter < 3)
                //{
                //    ++Licence.counter;
                //    str = Licence.Gethtml(a);
                //}
                //else
               
                   str = "Error Occured";
            }
            return str;
        }
    }
}
